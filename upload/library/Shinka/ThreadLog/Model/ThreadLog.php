<?php

class Shinka_ThreadLog_Model_ThreadLog extends Xenforo_Model
{
    public $forums;
    public $user_id = 0;
    public $threads = array();
    public $count = array(
        'active' => 0,
        'closed' => 0,
        'need_replies' => 0,
        'total' => 0
    );

	public function getThreadLog($user_id)
	{
        $this->forums = join(', ', XenForo_Application::get('options')->shinka_thread_log_forums);
        $this->user_id = $user_id;
        
        $this->threads = $this->_getDb()->fetchAll("
            SELECT thread.thread_id, thread.title, thread.discussion_open, thread.last_post_user_id,
            thread.last_post_username, thread.post_date, thread.prefix_id, node.title as node, node.node_id,
            thread.reply_count, thread.view_count, thread.username, user.avatar_date, user.timezone, user.user_id
            FROM xf_thread thread
            LEFT JOIN xf_user user ON user.user_id = thread.user_id
            LEFT JOIN xf_node node ON node.node_id = thread.node_id
            WHERE thread.discussion_state = 'visible'
            AND thread.node_id IN ($this->forums)
            AND EXISTS(
                SELECT 1 FROM xf_post post 
                WHERE thread.thread_id = post.thread_id
                AND post.message_state = 'visible'
                AND post.user_id = $user_id
            )
            ORDER BY thread.thread_id DESC
        ");

        $this->getCounts();

        return $this;
	}

    public function getCounts() {
        foreach ($this->threads as $thread) {
            if ($thread['discussion_open']) {
                $this->count['active']++;

                if ($thread['last_post_user_id'] != $this->user_id)
                    $this->count['need_replies']++;
            }
            else
                $this->count['closed']++;
        }

        $this->count['total'] = count($this->threads);
    }
}

?>