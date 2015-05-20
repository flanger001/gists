# config/initializers/i18n.rb

# Monkey-patch-in localization debugging
# http://cache.preserve.io/8vupog4s/index.html
# Modified from its original form.
# I do not recommend checking this file into VC; just use it and delete it when you're done.

module I18n
  module Backend
    class Simple
      def lookup(locale, key, scope = [], options = {})
        init_translations unless initialized?
        keys = I18n.normalize_keys(locale, key, scope, options[:separator])
        if Rails.env.development?
          Rails.logger.info "Key: \t #{key}"
        end

        keys.inject(translations) do |result, _key|
          _key = _key.to_sym
          return nil unless result.is_a?(Hash) && result.has_key?(_key)
          result = result[_key]
          result = resolve(locale, _key, result, options.merge(:scope => nil)) if result.is_a?(Symbol)

          Rails.logger.info "Result: \t\t => " + result.to_s + "\n\n" if (result.class == String)
          result
        end
      end
    end
  end
end