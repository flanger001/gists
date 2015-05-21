module MTA
  LINES = {
    n: ['ts', '34th', '28th-n', '23rd-n', 'us'],
    l: ['8th', '6th', 'us', '3rd', '1st'],
    s: ['gc', '33rd', '28th-s', '23rd-s', 'us']
  }

  class Route
    attr_accessor :start, :destination, :stops

    def initialize(start, destination)
      @start = { line: find_line_by_point(start), point: start }
      @destination = { line: find_line_by_point(destination), point: destination }
    end

    def stops
      start[:line] == destination[:line] ? same_line : different_line
    end

    private

    def lines
      LINES
    end

    def connector
      'us'
    end

    def connector_index(leg)
      lines[leg[:line]].index(connector)
    end

    def stop_index(leg)
      lines[leg[:line]].index(leg[:point])
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
        LINES.each { |k,v| @found = k if v.index(point) }
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