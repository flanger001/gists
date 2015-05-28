module MTA
  LINES = {
    n: ['ts', '34th', '28th-n', '23rd-n', 'us'],
    l: ['8th', '6th', 'us', '3rd', '1st'],
    s: ['gc', '33rd', '28th-s', '23rd-s', 'us']
  }

  class Line
    attr_accessor :name, :stops

    def initialize(name)
      @name = name
      @stops = LINES[name]
    end

    def connector
      'us'
    end
  end

  class Stop
    attr_accessor :name, :line, :position

    def initialize(name, line)
      @name = name
      @line = line
      @position = line.stops.index(name)
    end
  end

  class Route
    attr_accessor :start, :destination, :connector, :legs

    def initialize(start, destination)
      @start = start
      @destination = destination
      @connector = Stop.new(start.line.connector, start.line)
    end

    def distance_to_connector
      (start.position - connector.position).abs
    end

  end

  class Information
    attr_accessor :start_info, :destination_info, :route

    def initialize(route)
      @route = route
    end

    def start_info
      "Your trip starts at #{route.start.name} on the #{route.start.line.name} line"
    end

    def destination_info
      "Your trip ends at #{route.destination.name} on the #{route.destination.line.name} line"
    end
  end

end

include MTA

n = Line.new :n
l = Line.new :l
s = Line.new :s

start = Stop.new('34th', n)
destination = Stop.new('33rd', s)
route = Route.new(start, destination)
info = Information.new(route)
puts info.start_info
puts info.destination_info
