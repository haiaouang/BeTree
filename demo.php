<?php 

include 'AVLTree.php';
include 'TreeNode.php';

use BeTree\TreeNode;
use BeTree\AVLTree;

$avl = new AVLTree();
for ($i = 0; $i < 30; $i ++)
{
	$avl->Insert(mt_rand(1, 99));
}

print_r($avl->Find(8));

$avl->Traversal();

?>
