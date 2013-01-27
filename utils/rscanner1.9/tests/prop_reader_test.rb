$LOAD_PATH <<'./config'
require "test/unit"
require 'prop_reader'

class PropReaderTest < Test::Unit::TestCase

  def test_init_props
    props = PropReader.new
    assert_not_nil(props, message = "Failed to instantiate the PropReader")
  end

  def test_retrieve
    props = PropReader.new
    assert('/usr/local/www/apmgr/application/modules'.eql?(props.get_config('approot')) , "Failed to retrieve the main folder to scan")
  end

  def test_retrieve_fake_option
    props = PropReader.new
    assert_nil(props.get_config('foobar'), "We expected a nil result")
  end
end