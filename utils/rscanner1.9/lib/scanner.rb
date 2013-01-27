require 'logger'

class Scanner
  
  attr_reader :basePath , :folders
  
  public
  def init
    @controllerHash = Hash.new(h,k) { h[k]=[]  }
    @moduleHash =  Hash.new(h,k) { h[k]=[]  }
    @actionHash = Hash.new(h,k) { h[k]=[]  }
  end
  
  def get_logger
    if @logger==nil
      init_logger
    end
    return @logger
  end
  
  # => Set up each directory that we are going to parse
  def scan_directories
    @folders = {}
    @basePath = @config.get_config('approot')
    if(File.directory?(@basePath))    
        ignorePattern = @config.get_config('moduleignore').split(',')
    
        if ignorePattern.size==0
            ignorePattern[0] = '.'
        end
    
        Dir.foreach(@basePath){ |folder|
        if ignorePattern.include?(folder) == false
            @folders[folder] = @basePath+File::SEPARATOR+folder
        end
        }
    else
        print 'Cannot open directory '+@basePath
    end
  end
  
  # => For each of the directories , evaluate if we have it, else create it
  def populate_modules(dirname)
    log = get_logger
    result = get_module_id(dirname)
    log.debug("I'm inside populate_modules, with #{dirname}")
    if result==nil
      @dbinstance.query("INSERT INTO modules(name,dateCreated) VALUES('#{dirname}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
      log.debug("I'm running INSERT INTO modules(name,dateCreated) VALUES('#{dirname}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
      @moduleHash.clear
      init_hash('modules')
    end
  end
  
  # Set the attribute dbinstance to connect with the database
  def set_connector(connect)
    @dbinstance = connect
  end
  
  # => Set the properties of the system
  def set_properties(props)
    @config = props
  end
  
  # => For each module , check the controllers
  def scan_controllers(folder,path)
    target = @config.get_config('target')
    dirname = path + File::SEPARATOR + target
    Dir.foreach(dirname){|filename|
      if filename !~ /^\./
        scan_file(folder,dirname,filename)
      end
    }
  end
  
  def init_hash(hashName)
    log = get_logger
    result = @dbinstance.query("SELECT id,name FROM #{hashName}")
    log.debug("Running SELECT id,name FROM #{hashName} which obtained #{result.num_rows} records")
    array = {}
    while row=result.fetch_row do
      array[row[0]] = row[1]
    end
    
    case hashName
      when 'controllers'
      @controllerHash = array
      when 'modules'
      @moduleHash = array
      when 'actions'
      @actionHash = array
    end
    
  end
  
  protected
  # => This method retrieves one file that will be read and methods will be
  # => created in the database
  # => @param moduleName string the module name that you are iterating. Used for
  # fetching the module id
  # => @param path string The full path to the directory
  # => @param filename string the single filename
  def scan_file(moduleName,path,filename)
    log = get_logger
    log.debug("Inside scan_file ,args are module: #{moduleName},path: #{path}, filename: #{filename}")
    controllerName = filename.split(/Controller.php/)
    controllerName = controllerName[0].strip
    moduleId = get_module_id(moduleName)
    controllerId = get_controller_id(controllerName)
    # => Check , if this is a new record, just populate the controller table
    if controllerId==nil
      controllerId = create_controller(controllerName)
    end
    # => And now , read the file <strong>Recall that we are working on pages now</strong>
    controllerfilename = path + File::SEPARATOR + filename
    File.open(controllerfilename, 'r') { |content| read_file(content,controllerId,moduleId) }
  end
  
  # => Read a file and store the relation.
  # => @param resource filecontent The file content of the controller you are reading
  # => @param int controllerId The controller that you are using
  # => @param int moduleId The module you are using
  def read_file(filecontent,controllerId,moduleId)
    while( line=filecontent.gets )
      if valid_line(line)
        stub = line.split(/(Action\s?\(\)|public function|getResourceId)/)
        # stub = line.split(/(Action\s\(\)|public function|getResourceId)/)
        aname = stub[2].strip.capitalize
        actionName = aname.strip
        actionId = get_action_id(actionName)
        if actionId==nil
          actionId = create_action(actionName)
        end
        check_page_permision(moduleId, controllerId, actionId)
      end
    end
  end
  
  # If it starts with public function, is not toString and is not
  # commented and doesn't contains the name init, that is a reserved
  # keyword then consider this an action
  
  def valid_line(line)
    if line =~ /public function .+Action/ and line.include?("toString")==false and line.include?("//")==false and line.include?("init")==false and line.include?("ajax")==false
      return true
    else
      return false
    end
  end
  
  # => Retrieve the controllerId
  # => @param string controllerName
  def get_controller_id(controllerName)
    @controllerHash.key(controllerName)
  end
  
  # => Retrieve the moduleId
  def get_module_id(moduleName)
    if @moduleHash==nil
      @moduleHash = {}
    end
    @moduleHash.key(moduleName)
  end
  
  # => Retrieve the actionId
  def get_action_id(action)
    @actionHash.key(action)
  end
  
  # => Create the record in the table
  # => Each time that we do this , rehash the controllerhash
  # => @return int
  def create_controller(name)
    @dbinstance.query("INSERT INTO controllers(name,dateCreated) VALUES('#{name}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
    @controllerHash.clear
    init_hash('controllers')
    get_controller_id(name)
  end
  
  # => Create the record in the table
  # => Each time that we do this, rehash the actionHash
  # => @return int
  def create_action(actionName)
    log = get_logger
    @dbinstance.query("INSERT INTO actions(name,dateCreated) VALUES('#{actionName}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
    log.debug("I run INSERT INTO actions(name,dateCreated) VALUES('#{actionName}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
    @actionHash.clear
    init_hash('actions')
    get_action_id(actionName)
  end
  
  # => Verify if this combination exists , if it doesn't create it
  def check_page_permision(moduleId,controllerId,actionId)
    log = get_logger
    exists = @dbinstance.query("SELECT id FROM permission WHERE moduleId=#{moduleId} AND controllerId=#{controllerId} AND actionId=#{actionId}")
    log.debug("I'm in the core, running SELECT id FROM permission WHERE moduleId=#{moduleId} AND controllerId=#{controllerId} AND actionId=#{actionId}")
    if exists.num_rows==0
      aliasName = @moduleHash[moduleId].capitalize+" "+@controllerHash[controllerId].capitalize+" "+@actionHash[actionId].capitalize
      if aliasName.length==0
        log.debug("Okay , you found the error in this case, a 0 sized action for #{@moduleHash[moduleId]}:#{moduleId} and #{@controllerHash[controllerId]} #{controllerId} which will be ignored")
      else
        log.debug("That record did not exist , creating it with aliasName: #{aliasName}")
        @dbinstance.query("INSERT INTO permission(controllerId,actionId,moduleId,alias,dateCreated) VALUES(#{controllerId},#{actionId},#{moduleId},'#{aliasName}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")
        log.debug("And this is the query INSERT INTO permission(controllerId,actionId,moduleId,alias,dateCreated) VALUES(#{controllerId},#{actionId},#{moduleId},'#{aliasName}','#{Time.now.strftime('%Y-%m-%d %H:%I:%S')}')")  
      end
      
    else
      log.info("The combination #{moduleId} , #{controllerId} , #{actionId} existed")
    end
  end
  
  def init_logger
    # Prepare the outputfile
    outfile = @config.get_config('logfile')
    
    if File.exists?( outfile ) then           
        @logger = Logger.new(outfile)
        level = @config.get_config('loglevel')
        miss = false
        # Determine the log level
        case level
            when 'debug'
                @logger.level=(Logger::DEBUG)
            when 'warn'
                @logger.level=(Logger::WARN)
            when 'info'
                @logger.level=(Logger::INFO)
            when 'fatal'
                @logger.level=(Logger::FATAL)
            else
                miss = true
                @logger.level=(Logger::INFO)
        end
    else
      print 'Cannot open file ' + outfile
      exit!
    end 
    
    if miss
      @logger.info("Failed to determine the log level , using info")
    end
  end
end
