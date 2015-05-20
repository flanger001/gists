#! /usr/bin/env ruby
require 'active_support/inflector' # For pretty printing

home = Dir.pwd
Dir.chdir(home)

dirs = %W{base ckeditor cms drupal_rails_bridge gls_pro_2 user}

dirs.each do |dir|
  newdir = File.join(home, dir)
  puts "Pulling Gorges Rails #{dir.titleize} in #{newdir}"
  Dir.chdir(newdir)
  `git pull`
  puts "Git ref #{`git rev-parse head`} \n"
end