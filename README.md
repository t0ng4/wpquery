# wpquery
Wrapper around WP_Query for crafting fluent and expressive queries

__INSTALLATION__
```
composer require mynd/wpquery
```

_in PHP:_
```
...
use MYND\WQP\Classes\Query;
...
```
__USAGE__

_Retrieve posts of type page and default limit, status, etc._
```
$posts = Query::post()->ofType(['page'])->get();
```

_Retrieve posts with a meta_value `test_value` between 1 and 5_
```
$posts = Query::post()->withAnyOfMeta( [Query::postmeta( 'test_value' )->between( 1, 5 )] )->get();
```
_Get posts of type `artwork`  that are assigned to at least one of the taxonomies `color` with attributes (e.g. terms) `blue or red or green` 
 __OR__ the `size` taxonomy with sizes `s or m` __AND__ have a meta_key `test_value` with value between `1 and 5`_

```
$posts = Query::post()->ofType(['artwork'])
                      ->withAnyTaxonomy([ Query::taxonomy('color', ['blue','red','green']),
                                          Query::taxonomy('size', ['s','m']) ])
                      ->withAnyOfMeta( [ Query::postmeta( 'test_value' )->between( 1, 5 ) ] )
                      ->get();
```
