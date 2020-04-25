$(function () {
  const $searchForm = $('#search-form')
  $searchForm.each(function() {
    $('input[name=query]').keydown(function(event) {
      if (event.which === 10 || event.which === 13) {
        this.form.submit();
        return false;
      }
    });
  });

  let queryParam = location.search.split('query=')
  if (queryParam.length > 1) {
    queryParam = queryParam[1]
  } else {
    queryParam = ''
  }
  if ($searchForm.length) {
    $searchForm.attr('value', queryParam)
  }

  // Algolia search
  const search = instantsearch({
    appId: 'FGTZFTNRCI',
    apiKey: '89fe03b4e70cccc913c074009f696645',
    indexName: 'slbr',
    routing: true
  });

  // initialize SearchBox
  search.addWidget(
    instantsearch.widgets.searchBox({
      container: '#search-box',
      placeholder: 'Search for expressions'
    })
  );

  // initialize hits widget
  search.addWidget(
    instantsearch.widgets.hits({
      container: '#hits',
      templates: {
        empty: '<h2>No results</h2>',
        item: hit => `
                <li><h2><a href="${hit.permalink}">${hit.expression}</a></h2></li>
            `
      }
    })
  );

  // initialize pagination
  search.addWidget(
    instantsearch.widgets.pagination({
      container: '#pagination',
      maxPages: 20,
      // default is to scroll to 'body', here we disable this behavior
      scrollTo: false
    })
  );

  search.start();
});


