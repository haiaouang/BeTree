<?php 
/**
 * BeTree
 *
 * One on the balance of the two fork tree demo!
 *
 *
 * @package	BeTree
 * @author Huang Hao Tao 
 */

namespace BeTree;

/**
 * TreeNode Class
 *
 * This is a tree structure.
 *
 *
 * @package	BeTree
 * @author Huang Hao Tao 
 */
class TreeNode {

	/**
	 * Reference to the BeTree TreeNode
	 *
	 * @var	object
	 */
	public $left_son = null;

	/**
	 * Reference to the BeTree TreeNode
	 *
	 * @var	object
	 */
	public $right_son = null;

	/**
	 * TreeNode Data
	 *
	 * @var	int
	 */
	public $data = 0;

	/**
	 * TreeNode Frequency
	 *
	 * @var	int
	 */
	public $frequency = 1;

	/**
	 * TreeNode Height
	 *
	 * @var	int
	 */
	public $height = 1;
	
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct() 
	{

	}
	
}


?>
