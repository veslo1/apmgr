require 'rubygems'
require 'mysql'

class WrapMysql

  def init_db
    @dbinstance = Mysql.new(get_host,get_user,get_pass,get_dbname)
  end

  def get_instance
    @dbinstance
  end

  def set_props(props)
    @props = props
  end

  private

  def get_host
    @props.get_config('host')
  end

  def get_user
    @props.get_config('dbuser')
  end

  def get_pass
    @props.get_config('dbpass')
  end

  def get_dbname
    @props.get_config('dbname')
  end
end
