# To change this template, choose Tools | Templates
# and open the template in the editor.
$LOAD_PATH <<'./config'

$:.unshift File.join(File.dirname(__FILE__),'..','lib')
require 'test/unit'
require 'wrap_mysql'
require 'scanner'
require 'prop_reader'

class ScannerTest < Test::Unit::TestCase
  def test_scan_controllers
    props = PropReader.new
    assert_not_nil(props, message = "Failed to load the properties")
    wm = WrapMysql.new
    wm.set_props(props)
    wm.init_db
    scan = Scanner.new
    # => Initialize the attributes
    scan.set_properties(props)
    scan.set_connector(wm.get_instance)
    # => Store the info in the attributes
    scan.init_hash('modules')
    scan.init_hash('controllers')
    scan.init_hash('actions')

    scan.scan_directories
    buffer = scan.folders.sort
    assert(buffer.class==Array)
    assert(buffer.size>0,'We did not generate a big array')
    buffer.each { |key,path| scan.populate_modules key }
    buffer.each { |key,path| scan.scan_controllers(key, path)}
  end
end