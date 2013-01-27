require 'yaml'

class PropReader
  # Retrieve the configuration option that you retrieved
  def get_config(option)
    if @config==nil
      @config = YAML.load_file(File.expand_path(File.dirname(__FILE__))+"/../config/options.yml")
    end
    @config['options'][option]
  end

end