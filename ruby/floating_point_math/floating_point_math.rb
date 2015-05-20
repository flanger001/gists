x = [78894.96,62810.80,49448.50,2200.00]
puts x
puts
puts x.inject { |sum, x| sum + x }
puts x.inject { |sum, x| sum + x.floor }
puts x.inject { |sum, x| sum + x.round }
puts x.inject { |sum, x| sum.floor + x }
puts x.inject { |sum, x| sum.floor + x.floor }
puts x.inject { |sum, x| sum.floor + x.round }
puts x.inject { |sum, x| sum.round + x }
puts x.inject { |sum, x| sum.round + x.floor }
puts x.inject { |sum, x| sum.round + x.round }
puts
puts x.inject { |sum, x| sum + x }.floor
puts x.inject { |sum, x| sum + x.floor }.floor
puts x.inject { |sum, x| sum + x.round }.floor
puts x.inject { |sum, x| sum.floor + x }.floor
puts x.inject { |sum, x| sum.floor + x.floor }.floor
puts x.inject { |sum, x| sum.floor + x.round }.floor
puts x.inject { |sum, x| sum.round + x }.floor
puts x.inject { |sum, x| sum.round + x.floor }.floor
puts x.inject { |sum, x| sum.round + x.round }.floor
puts
puts x.inject { |sum, x| sum + x }.round
puts x.inject { |sum, x| sum + x.floor }.round
puts x.inject { |sum, x| sum + x.round }.round
puts x.inject { |sum, x| sum.floor + x }.round
puts x.inject { |sum, x| sum.floor + x.floor }.round
puts x.inject { |sum, x| sum.floor + x.round }.round
puts x.inject { |sum, x| sum.round + x }.round
puts x.inject { |sum, x| sum.round + x.floor }.round
puts x.inject { |sum, x| sum.round + x.round }.round