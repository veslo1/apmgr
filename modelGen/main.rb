path = File.expand_path(File.dirname(__FILE__))
require  path+File::SEPARATOR+'lib'+File::SEPARATOR+'prop_reader'
require  path+File::SEPARATOR+'lib'+File::SEPARATOR+'wrap_mysql' 
require 'getoptlong'


props = PropReader.new
WrapMysqlObj = WrapMysql.new
WrapMysqlObj.set_props(props)
WrapMysqlObj.init_db
db = WrapMysqlObj.get_instance
opts = GetoptLong.new(
                      [ '--help', '-h', GetoptLong::NO_ARGUMENT ],
[ '--model', '-n', GetoptLong::REQUIRED_ARGUMENT ],
[ '--author', GetoptLong::OPTIONAL_ARGUMENT ],
[ '--zendModule',GetoptLong::OPTIONAL_ARGUMENT ]
)


model = nil
author = 'Complete with your name <andyouremail@debserverp4.com.ar>'
zendModule = 'complete'

opts.each do |opt, arg|
print opt
  case opt
    when '--help'
    # RDoc::usage
    puts "\nExample ruby main.rb --model applicantFeeBill --zendModule Applicant --author '<jvazquez@debserverp4.com.ar>'"
    exit 0 
    when '--model'
    model = arg
    when '--author'
    author = arg
  when '--zendModule'
    zendModule = arg
  end
end

if model.empty? | model.length==0
  puts "Missing model (try --help)"
  exit 0
end

#Where we store the file
outfile = path+File::SEPARATOR+props.get_config('target')+File::SEPARATOR+model.capitalize+".php"

f=File.open(outfile, 'w')
f.write "<?php\n"
f.write "/**\n"
f.write " *\n"
f.write " * @author #{author}\n"
f.write " */\n"
f.write "class #{zendModule}_Model_#{model.capitalize} extends ZFModel_ParentModel {\n\n"
f.write "public function __construct(array $options=null) { \n"
f.write " parent::__construct($options);\n"
f.write "//TODO verify this line if you see complete, and use your proper module\n";
f.write " $this->setDbTable('#{zendModule}_Model_DbTable_#{zendModule.capitalize}');"
f.write "}\n"

result = db.query("EXPLAIN #{model}");

while row=result.fetch_row do
  f.write "/**\n"
  f.write " * @var #{row[2]} $#{row[0]}\n"
  f.write "*/\n"
  f.write "protected $#{row[0]};\n"
  f.write "\n"
  f.write "/**\n"
  f.write " * Set #{row[0]}\n"
  f.write "*/\n"
  f.write "public function set#{row[0].capitalize}($#{row[0]}) {\n"
  f.write " $this->#{row[0]}=$#{row[0]};\n"
  f.write " return $this;\n"
  f.write "}\n"
  
  f.write "/**\n"
  f.write " * Get #{row[0]}\n"
  f.write " */\n"
  f.write "public function get#{row[0].capitalize}() {\n"
  f.write " return $this->#{row[0]};\n"
  f.write "}\n"
end
f.write"}\n"
f.close
