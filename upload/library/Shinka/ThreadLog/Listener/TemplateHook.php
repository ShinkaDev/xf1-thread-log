<?php



class Shinka_ThreadLog_Listener_TemplateHook extends Waindigo_Listener_TemplateHook
{
    protected function _getHooks()
    {
        return array(
            'member_view_tabs_heading',
            'member_view_tabs_content',
        );
    }

    public static function templateHook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
    {
        $templateHook = new self($hookName, $contents, $hookParams, $template);
        $contents = $templateHook->run();
    }

    protected function _memberViewTabsHeading()
    {
        $user_ids = array_map('intval', explode(',', $this->_fetchViewParams()['user']['secondary_group_ids']));
        if (array_intersect(array_keys(XenForo_Application::get('options')->shinka_thread_log_groups), 
                            $user_ids)) {
            $this->_appendTemplate('shinka_thread_log_tabs_heading');
        }
    }

    protected function _memberViewTabsContent()
    {
        $params = $this->_fetchViewParams();        
        $user_ids = array_map('intval', explode(',', $params['user']['secondary_group_ids']));
        if (array_intersect(array_keys(XenForo_Application::get('options')->shinka_thread_log_groups), 
                            $user_ids) &&
            $thread_log = XenForo_Model::create('Shinka_ThreadLog_Model_ThreadLog')->getThreadLog($params['user']['user_id']))
        {
            $viewParams = array(
                'threads' => $thread_log->threads,
                'count' => $thread_log->count,
                'forums' => $thread_log->forums,
                'user_id' => $thread_log->user_id
            );
            
            $this->_appendTemplate('shinka_thread_log_tabs_content', $viewParams);
        }
    }
}

