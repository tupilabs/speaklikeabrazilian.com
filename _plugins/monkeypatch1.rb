# Original code: https://github.com/sverrirs/jekyll-paginate-v2/blob/25b0d43308b1c50228cd9177ce8d19ba941c8d2b/lib/jekyll-paginate-v2/generator/utils.rb#L82
# Monkey patching Jekyll PaginateV2 class Utils for
# https://github.com/sverrirs/jekyll-paginate-v2/issues/187
# and https://github.com/tupilabs/speaklikeabrazilian.com/issues/47

module Jekyll
  module PaginateV2::Generator
    class Utils
      @@collator = TwitterCldr::Collation::Collator.new(:pt)
      def self.sort_values(a, b)
        return @@collator.compare(a.downcase, b.downcase)
      end
    end
  end
end
