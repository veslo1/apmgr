# To change this template, choose Tools | Templates
# and open the template in the editor.

$:.unshift File.join(File.dirname(__FILE__),'..','lib','config')

require 'test/unit'
require 'prop_reader'
require 'wrap_mysql'

class WrapMysqlTest < Test::Unit::TestCase
  def test_instance
    props = PropReader.new
    wm = WrapMysql.new
    wm.set_props(props)
    wm.init_db
    inst = wm.get_instance
    assert_not_nil(inst, "The database connection is not working")
  end
end