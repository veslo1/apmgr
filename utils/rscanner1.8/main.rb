path = File.expand_path(File.dirname(__FILE__))
require  path+File::SEPARATOR+'lib'+File::SEPARATOR+'prop_reader'
require  path+File::SEPARATOR+'lib'+File::SEPARATOR+'wrap_mysql' 
require path+File::SEPARATOR+'lib'+File::SEPARATOR+'scanner'

# on windows had to download this file to get it to work ok on mysql
# http://instantrails.rubyforge.org/svn/trunk/InstantRails-win/InstantRails/mysql/bin/libmySQL.dll
# Download this file and replace in c:\ruby\bin\
# Rerun program

puts 'Starting program...'
props = PropReader.new
wm = WrapMysql.new
scan = Scanner.new
# => Initialize the attributes
puts 'Initializing...'
wm.set_props(props)
wm.init_db
scan.set_connector(wm.get_instance)
scan.set_properties(props)

# => Prepare the module hash, the controller hash and the action hash
puts 'Preparing hashes...'
scan.init_hash('modules')
scan.init_hash('controllers')
scan.init_hash('actions')

# => Scan our directories
puts 'Scanning directories...'
scan.scan_directories
buffer = scan.folders.sort

# => Check module sanity , if this entry isn't on our db, create it and rebuild
# => the module hash
buffer.each { |key,path| scan.populate_modules key }

# => This is the bulk job now, scan each module folder, descend into the contro-
# => llers and verify each action.
buffer.each { |key,path| scan.scan_controllers(key, path)}
puts "End of run"
