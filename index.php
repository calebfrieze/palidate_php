<?php

require_once('./src/Palidate.php');

$options = [
  'env' => 'live', 
  'clientId' => 'ASkA-dTvxBkypQl3kZ416Zm90B5hGgzWR2bzNv9kpKn8UOrFFcN6UQJ3OgJdShlu2teSILfFg_AKnBCz', 
  'clientSecret' => 'EOdgzAb-D7EL4kBIvOZZKD636WgoWmpuI-zrHTfd-p7q2U08Oj9KM3iChQQ2EnO-wIACOwNF8dkr2fYA'
];

$palidate = new Palidate\Palidate\Palidate($options);
echo '<pre>';
print_r($palidate->palidate());

echo '</pre><div>';
echo 'Token Type: ';
print_r($palidate->getTokenType());
echo '</div><pre>';
echo 'Scope: ';
print_r($palidate->getScope(true));
echo '</pre><div>';
echo 'Expires In: ';
print_r($palidate->getExpireTime());
echo '</div>';
?>