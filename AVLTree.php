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
 * AVLTree Class
 *
 * This is a balanced two fork tree implementation class.
 *
 *
 * @package	BeTree
 * @author Huang Hao Tao 
 */
class AVLTree {

	/**
	 * Reference to the BeTree TreeNode
	 *
	 * @var	object
	 */
	private $_tree_node = null;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct() 
	{

	}

	/**
	 * Insert
	 *
	 * Insert a new number to balance the two fork tree.
	 *
	 * @param	int		$data	It's a number
	 * @return 	void
	 */
	public function Insert($data)
	{
		$this->_Insert($this->_tree_node, $data);
	}

	/**
	 * Find
	 *
	 * Tree structure for searching digital correspondence.
	 *
	 * @param	int			$data	It's a number
	 * @return 	object|null	
	 */
	public function Find($data)
	{
		return $this->_Find($this->_tree_node, $data);
	}

	/**
	 * Delete
	 *
	 * Delete a number from the balance of the two fork tree.
	 *
	 * @param	int		$data	It's a number
	 * @return 	void
	 */
	public function Delete($data)
	{
		$this->_Delete($this->_tree_node, $data);
	}

	/**
	 * Traversal
	 *
	 * Traversing the balance of the two tree and output to the web page.
	 *
	 * @return 	void
	 */
	public function Traversal()
	{
		//把树形转换为数组以便输出
		$array = array();
		$this->_TreeToArray($this->_tree_node, 0, $array);

		//判断最后最后一排是否不存在的并去掉
		$count = count($array);
		if (max($array[$count - 1]) == 0) unset($array[$count - 1]);

		//遍历并输出到页面 （输出可是是按照2位数字输出的）
		$count = count($array); 
		$col = 2 * pow(2, $count - 1) - 1;
		for($i = 0; $i < $count; $i ++)
		{
			$l_col = intval(($col - pow(2, $i)) / pow(2, $i + 1));
			for($j = 0; $j < $l_col; $j ++) echo '&nbsp;';
			foreach ($array[$i] as $value)
			{
				echo $value > 0 ? ($value > 9 ? $value : $value . ' ') : '&nbsp;';
				if ($i > 0)
				{
					for ($n = 0; $n < intval(($col - 2 * $l_col - pow(2, $i)) / (pow(2, $i) - 1)); $n ++) echo '&nbsp;';
				}
			}
			
			echo "<br/>";
		}
	}

	/**
	 * Private Insert
	 *
	 * Insert a new number to balance the two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @param	int		$data		It's a number
	 * @return 	void
	 */
	private function _Insert(& $tree_node, $data)
	{
		if ($tree_node == null)
		{
			$tree_node = new TreeNode();
			$tree_node->data = $data;
			return;
		}

		if ($data < $tree_node->data)
		{
			$this->_Insert($tree_node->left_son, $data);

			if (2 == $this->_Height($tree_node->left_son) - $this->_Height($tree_node->right_son))
			{
				if ($data < $tree_node->left_son->data)
					$this->_SingleRotateLeft($tree_node);
				else
					$this->_DoubleRotateLR($tree_node);
			}
		} 
		else if ($data > $tree_node->data) 
		{
			$this->_Insert($tree_node->right_son, $data);

			if (2 == $this->_Height($tree_node->right_son) - $this->_Height($tree_node->left_son))
			{
				if ($data > $tree_node->right_son->data)
					$this->_SingleRotateRight($tree_node);
				else 
					$this->_DoubleRotateRL($tree_node);
			}		
		} 
		else 
			++ $tree_node->frequency;

		$tree_node->height = $this->_MaxHeight($tree_node->left_son, $tree_node->right_son) + 1;
	}

	/**
	 * Private Find
	 *
	 * Tree structure for searching digital correspondence.
	 *
	 * @param	object		$tree_node	Tree structure
	 * @param	int			$data		It's a number
	 * @return 	object|null	
	 */
	private function _Find($tree_node, $data)
	{
		if ($tree_node == null) return null;

		if ($data < $tree_node->data)
		{
			return $this->_Find($tree_node->left_son, $data);
		}
		else if ($data > $tree_node->data)
		{
			return $this->_Find($tree_node->right_son, $data);
		}
		else
			return $tree_node;
	}

	/**
	 * Private Delete
	 *
	 * Delete a number from the balance of the two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @param	int		$data		It's a number
	 * @return 	void
	 */
	private function _Delete(& $tree_node, $data)
	{
		if ($tree_node == null) return;

		if ($data < $tree_node->data)
		{
			$this->_Delete($tree_node->left_son, $data);

			if (2 == $this->_Height($tree_node->right_son) - $this->_Height($tree_node->left_son))
			{
				if ($tree_node->right_son->left_son != null && ($this->_Height($tree_node->right_son->left_son) > $this->_Height($tree_node->right_son->right_son)))
					$this->_DoubleRotateRL($tree_node);
				else
					$this->_SingleRotateRight($tree_node);
			}
		}
		else if ($data > $tree_node->data)
		{
			$this->_Delete($tree_node->right_son, $data);

			if (2 == $this->_Height($tree_node->left_son) - $this->_Height($tree_node->right_son))
			{
				if ($tree_node->left_son->right_son != null && ($this->_Height($tree_node->left_son->right_son) > $this->_Height($tree_node->left_son->left_son)))
					$this->_DoubleRotateLR($tree_node);
				else
					$this->_SingleRotateLeft($tree_node);
			}
		}
		else
		{
			if ($tree_node->left_son != null && $tree_node->right_son != null)
			{
				$tree_node_t = $tree_node->right_son;
				while ($tree_node_t->left_son != null) $tree_node_t = $tree_node_t->left_son;

				$tree_node->data = $tree_node_t->data;
				$tree_node->frequency = $tree_node_t->frequency;

				$this->_Delete($tree_node->right_son, $tree_node_t->data);

				if (2 == $this->_Height($tree_node->left_son) - $this->_Height($tree_node->right_son))
				{
					if ($tree_node->left_son->right_son != null && ($this->_Height($tree_node->left_son->right_son) > $this->_Height($tree_node->left_son->left_son)))
						$this->_DoubleRotateLR($tree_node);
					else
						$this->_SingleRotateLeft($tree_node);
				}
			}
			else
			{
				if ($tree_node->left_son == null)
					$tree_node = $tree_node->right_son;
				else if ($tree_node->right_son == null)
					$tree_node = $tree_node->left_son;
			}
		}

		if ($tree_node == null) return;

		$tree_node->height = $this->_MaxHeight($tree_node->left_son, $tree_node->right_son) + 1;
	}

	/**
	 * Private TreeToArray
	 *
	 * The tree structure is transformed into an array.
	 *
	 * @param	object  $tree_node	Tree structure
	 * @param	int		$floor		Layer number of tree structure
	 * @param	array	$array		Array reference
	 * @return 	void
	 */
	private function _TreeToArray($tree_node, $floor, & $array)
	{
		if ($tree_node == null)
		{
			$array[$floor][] = 0;
			return;
		}
		$array[$floor][] = $tree_node->data;
		$this->_TreeToArray($tree_node->left_son, ($floor + 1), $array);
		$this->_TreeToArray($tree_node->right_son, ($floor + 1), $array);
	}

	/**
	 * Private SingleRotateLeft
	 *
	 * Transfer of the tree structure through the left left 
	 * to maintain a balance of two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @return 	void
	 */
	private function _SingleRotateLeft(& $tree_node)
	{
		$tree_node_l = $tree_node->left_son;
		$tree_node->left_son = $tree_node_l->right_son;
		$tree_node->height = $this->_MaxHeight($tree_node->left_son, $tree_node->right_son) + 1;

		$tree_node_l->right_son = $tree_node;
		$tree_node_l->height = $this->_MaxHeight($tree_node_l->left_son, $tree_node_l->right_son) + 1;
		
		$tree_node = $tree_node_l;
	}

	/**
	 * Private SingleRotateRight
	 *
	 * Transfer of the tree structure through the right right 
	 * to maintain a balance of two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @return 	void
	 */
	private function _SingleRotateRight(& $tree_node)
	{
		$tree_node_r = $tree_node->right_son;
		$tree_node->right_son = $tree_node_r->left_son;
		$tree_node->height = $this->_MaxHeight($tree_node->left_son, $tree_node->right_son) + 1;

		$tree_node_r->left_son = $tree_node;
		$tree_node_r->height = $this->_MaxHeight($tree_node_r->left_son, $tree_node_r->right_son) + 1;

		$tree_node = $tree_node_r;
	}

	/**
	 * Private DoubleRotateLR
	 *
	 * Transfer of the tree structure through the left right 
	 * to maintain a balance of two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @return 	void
	 */
	private function _DoubleRotateLR(& $tree_node)
	{
		$this->_SingleRotateRight($tree_node->left_son);
		$this->_SingleRotateLeft($tree_node);
	}

	/**
	 * Private DoubleRotateRL
	 *
	 * Transfer of the tree structure through the right left
	 * to maintain a balance of two fork tree.
	 *
	 * @param	object  $tree_node	Tree structure reference
	 * @return 	void
	 */
	private function _DoubleRotateRL(& $tree_node)
	{
		$this->_SingleRotateLeft($tree_node->right_son);
		$this->_SingleRotateRight($tree_node);
	}

	/**
	 * Private Height
	 *
	 * Gets the height of the tree structure.
	 *
	 * @param	object  $tree_node	Tree structure
	 * @return 	int
	 */
	private function _Height($tree_node)
	{
		if ($tree_node == null)
			return 0;
		else if (get_class($tree_node) == TreeNode::class)
			return $tree_node->height;
		else 
			return 0;
	}

	/**
	 * Private Max
	 *
	 * Comparison of the two tree structure that high.
	 *
	 * @param	object  $tree_node	Tree structure
	 * @param	object  $tree_node	Tree structure
	 * @return 	object
	 */
	private function _Max($tree_node1, $tree_node2)
	{
		$_height1 = $this->_Height($tree_node1);
		$_height2 = $this->_Height($tree_node2);

		return $_height1 > $_height2 ? $tree_node1 : $tree_node2;
	}

	/**
	 * Private Max Height
	 *
	 * Comparison of the two tree structure that high.
	 *
	 * @param	object  $tree_node	Tree structure
	 * @param	object  $tree_node	Tree structure
	 * @return 	int
	 */
	private function _MaxHeight($tree_node1, $tree_node2)
	{
		$_height1 = $this->_Height($tree_node1);
		$_height2 = $this->_Height($tree_node2);

		return $_height1 > $_height2 ? $_height1 : $_height2;
	}

}


?>
