# K-D Trees
[![CircleCI](https://circleci.com/gh/f1r3starter/kdtree.svg?style=svg)](https://circleci.com/gh/f1r3starter/kdtree)
[![codecov](https://codecov.io/gh/f1r3starter/kdtree/branch/master/graph/badge.svg)](https://codecov.io/gh/f1r3starter/kdtree)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/f1r3starter/kdtree/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/f1r3starter/kdtree/?branch=master)


This is basic implementation of K-D trees in PHP inspired by Princeton [K-D trees assignment](https://www.cs.princeton.edu/courses/archive/fall19/cos226/assignments/kdtree/specification.php) and done as a graduation project for [Algorithms Course in Projector](https://prjctr.com.ua/algorithms-base.html).


# Installation

```bash
composer require f1r3starter/kdtree
```

# Usage
## Tree construction

Firstly, you have to decide, how many dimensions your tree is going to be used for, after that you can add some points:
```php
<?php

use KDTree\Structure\KDTree;  
use KDTree\ValueObject\Point;

$kdTree = new KDTree(2); // 2 for two-dimensional points, eg cities
$kdTree->put(new Point(35.0844, 106.6504)); 
$kdTree->put(new Point(41.2865, 174.7762));

// if you need somehow connect point to your application, you can use setName method
$point = new Point(46.8117, 33.4902);
$point->setName('Kakhovka');
$kdTree->put($point);
//...
$points = $kdTree->points(); // returns list of all points, which can be iterated through

$kdTree->contains(new Point(46.8117, 33.4902)); // will return "true"
```

## Nearest point search

After tree is constructed, we can try to find nearest point:
```php
<?php

use KDTree\Search\NearestSearch;
use KDTree\ValueObject\Point;

$search = new NearestSearch($kdTree);
$nearestPoint = $search->nearest((new Point(41.2865, 174.7762)));
```

## Range search



```php
<?php

use KDTree\Structure\PointsList;
use KDTree\Search\PartitionSearch;
use KDTree\ValueObject\{Partition, Point};

$pointsList = new PointsList(2);  
$pointsList->addPoint(new Point(46.8117, 33.4902));  
$pointsList->addPoint(new Point(31.3142, 42.5245));  
$pointsList->addPoint(new Point(22.2525, 41.3412));  
$pointsList->addPoint(new Point(55.4245, 52.5134));  
$search = new PartitionSearch($kdTree);  
$foundPoints = $search->find(new Partition($pointsList));
```
  
## Credits

- [Andrii Filenko](https://github.com/f1r3starter)
