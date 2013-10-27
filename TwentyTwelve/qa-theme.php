<?php
	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}
	class qa_html_theme extends qa_html_theme_base{
	
		function logo()
		{
			$this->output('<DIV CLASS="qa-logo">');
			$this->output('<h1>'.$this->content['logo'].'</h1>');
			$this->output('<h2 class="qa-site-description">'.qa_opt('home_description').'</h2>');
			$this->output('</DIV>');
			//var_dump(qa_opt('home_description'));
		}
		
		function nav_link($navlink, $class)
		{
			if (isset($navlink['url'])) {
				$this->output(
					'<A HREF="'.$navlink['url'].'" CLASS="qa-'.$class.'-link'.
					(@$navlink['selected'] ? (' qa-'.$class.'-selected') : '').'"'.
					(strlen(@$navlink['popup']) ? (' TITLE="'.$navlink['popup'].'"') : '').
					(isset($navlink['target']) ? (' TARGET="'.$navlink['target'].'"') : '').'>'.$navlink['label'].
					'</A>'
				);

			} else
				$this->output($navlink['label']);

			if (strlen(@$navlink['note']))
				$this->output('<SPAN CLASS="qa-'.$class.'-note">'.$navlink['note'].'</SPAN>');
		}
		
		function attribution()
		{
			// Hi there. I'd really appreciate you displaying this link on your Q2A site. Thank you - Gideon
				
			$this->output(
				'<DIV CLASS="qa-attribution">',
				'Theme by <a href="http://www.qa-themes.com" title="best Q2A themes">QA-Themes</a>, ',
				'Powered by <A HREF="http://www.question2answer.org/">Question2Answer</A>',
				'</DIV>'
			);
		}
		
		function ranking_score($item, $class)
		{
			$this->output('<TD CLASS="'.$class.'-score">'.$item['score'].'</TD>');
		}
		
		function post_avatar($post, $class, $prefix=null)
		{
			if (isset($post['avatar'])) {
				if (isset($prefix))
					$this->output($prefix);

				$this->output('<SPAN CLASS="'.$class.'-avatar">', $post['avatar'], '</SPAN>');
			}
		}
		
		
		function post_meta_what($post, $class)
		{
			if (isset($post['what'])) {
				if (isset($post['what_url']))
					$this->output('<A HREF="'.$post['what_url'].'" CLASS="'.$class.'-what">'.$post['what'].'</A>');
				else
					$this->output('<SPAN CLASS="'.$class.'-what">'.$post['what'].'</SPAN>');
			}
		}
		
		function q_view($q_view)
		{
			if (!empty($q_view)) {
				$this->output('<DIV CLASS="qa-q-view'.(@$q_view['hidden'] ? ' qa-q-view-hidden' : '').rtrim(' '.@$q_view['classes']).'"'.rtrim(' '.@$q_view['tags']).'>');
				
				if (isset($q_view['main_form_tags']))
					$this->output('<FORM '.$q_view['main_form_tags'].'>'); // form for voting buttons
				
				$this->voting($q_view);
				
				if (isset($q_view['main_form_tags']))
					$this->output('</FORM>');
					
				$this->a_count($q_view);
				$this->q_view_main($q_view);
				$this->q_view_clear();
				
				$this->output('</DIV> <!-- END qa-q-view -->', '');
			}
		}
		
		function a_list($a_list)
		{
			if (!empty($a_list)) {
				$this->section(@$a_list['title']);
				
				$this->output('<DIV CLASS="qa-a-list'.($this->list_vote_disabled($a_list['as']) ? ' qa-a-list-vote-disabled' : '').'" '.@$a_list['tags'].'>', '');
				
				foreach ($a_list['as'] as $a_item)
					$this->a_list_item($a_item);
				
				$this->output('</DIV> <!-- END qa-a-list -->', '');
			}
		}
		
		function c_list($c_list, $class)
		{
			if (!empty($c_list)) {
				$this->output('', '<DIV CLASS="'.$class.'-c-list"'.(@$c_list['hidden'] ? ' STYLE="display:none;"' : '').' '.@$c_list['tags'].'>');
				
				foreach ($c_list['cs'] as $c_item)
					$this->c_list_item($c_item);
				
				$this->output('</DIV> <!-- END qa-c-list -->', '');
			}
		}
		
		function view_count($post)
		{
		
		}
		function view_counts($post)
		{
			$this->output_split(@$post['views'], 'qa-view-count');
		}
	}	
/*
	Omit PHP closing tag to help avoid accidental output
*/