module MTA
  LINES = {
    n: ['ts', '34th', '28th-n', '23rd-n', 'us'],
    l: ['8th', '6th', 'us', '3rd', '1st'],
    s: ['gc', '33rd', '28th-s', '23rd-s', 'us']
  }

  Stop = Struct.new(:line, :point)

  class Route
    attr_accessor :start, :destination, :stops, :information

    def initialize(start, destination)
      @start = Stop.new(find_line_by_point(start), start)
      @destination = Stop.new(find_line_by_point(destination), destination)
    end

    def stops
      switches_lines? ? different_line : same_line
    end

    private

    def lines
      LINES
    end

    def switches_lines?
      start.line != destination.line
    end

    def connector
      'us'
    end

    def connector_index(leg)
      lines[leg.line].index(connector)
    end

    def stop_index(leg)
      lines[leg.line].index(leg.point)
    end

    def same_line
      (stop_index(start) - stop_index(destination)).abs
    end

    def different_line
      first_leg = stop_index(start) - connector_index(start)
      second_leg = stop_index(destination) - connector_index(destination)
      first_leg.abs + second_leg.abs
    end

    def find_line_by_point(point)
      found ||= begin
        @found = ''
        lines.each { |k,v| @found = k if v.index(point) }
        @found
      end
    end

  end

end

a = MTA::Route.new("28th-n", "23rd-n")
puts a.stops
puts a.start
puts a.destination

b = MTA::Route.new("gc", "8th")
puts b.stops

c = MTA::Route.new("gc", "23rd-n")
puts c.stops