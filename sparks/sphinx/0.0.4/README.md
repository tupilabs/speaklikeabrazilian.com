##This is the codeigniter interface to the sphinx search engine.

This is the minimal requirement release. You need to have 
sphinxsearch properly installed. 

This library will use sphinxsearch API approach. It delegates 
method calls to the sphinxsearch client following the ci convention.
Ex if sphinx client have method named SetServer you can call it via
$this->sphinxsearch->set_server($params_here)

You can configure some settings like server etc by omitting the set 
and use snakes instead of camels. 
Ex since we have SetMaxQueryTime method we can set $config['max_query_time']  = 1000

At this moment indexing is not supported but will be added in the future. 

Usage:
$this->load->spark('sphinx/0.0.1'); $result = $this->sphinxsearch->query("test");

