<?php

namespace Evan\Menus;

use ElggBlog;
use ElggBookmark;
use ElggWire;
use Evan\Menu;
use FilePluginFile;
use TidypicsAlbum;

class Composer {
	
	public function register($hook, $type, $return, $params) {
		$menu = new Menu($return);
		$target = $params['target'];
		
		if (class_exists('ElggWire')) {
			if (evan_user_can('post', new ElggWire(), $target)) {
				$menu->registerItem('thewire', array(
					'href' => "/ajax/view/thewire/composer?container_guid=$target->guid",
					'text' => elgg_view_icon('share') . elgg_echo("composer:object:thewire"),
					'priority' => 100,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('thewire/composer');
			}
		}
		
		if (elgg_is_active_plugin('messageboard')) {
			if ($target->canAnnotate(0, 'messageboard')) {
				$menu->registerItem('messageboard', array(
					'href' => "/ajax/view/messageboard/composer?entity_guid=$target->guid",
					'text' => elgg_view_icon('speech-bubble-alt') . elgg_echo("composer:annotation:messageboard"),
					'priority' => 200,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('messageboard/composer');
			}
		}
		
		if (class_exists('ElggBookmark')) {
			if (evan_user_can('post', new ElggBookmark(), $target)) {
				$menu->registerItem('bookmarks', array(
					'href' => "/ajax/view/bookmarks/composer?container_guid=$target->guid",
					'text' => elgg_view_icon('push-pin') . elgg_echo("composer:object:bookmarks"),
					'priority' => 300,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('bookmarks/composer');
			}
		}
		
		if (class_exists('TidypicsAlbum')) {
			if (evan_user_can('post', new TidypicsAlbum(), $target)) {
				$menu->registerItem('album', array(
					'href' => "/ajax/view/photos/album/composer?container_guid=$target->guid",
					'text' => elgg_view_icon('photo') . elgg_echo("composer:object:album"),
					'priority' => 400,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('photos/album/composer');
			}
		}
		
		if (class_exists('ElggBlog')) {
			if (evan_user_can('post', new ElggBlog(), $target)) {
				$menu->registerItem('blog', array(
					'href' => "/ajax/view/blog/composer?container_guid=$target->guid",
					'text' => elgg_view_icon('speech-bubble') . elgg_echo("composer:object:blog"),
					'priority' => 600,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('blog/composer');
			}
		}
		
		if (class_exists('FilePluginFile')) {
			if (evan_user_can('post', new FilePluginFile(), $target)) {
				$menu->registerItem('file', array(
					'href' => "/ajax/view/file/composer?container_guid=$target->guid",
					'text' => elgg_view_icon('clip') . elgg_echo("composer:object:file"),
					'priority' => 700,
				));
				
				//trigger any javascript loads that we might need
				elgg_view('file/composer');
			}
		}
		
		return $menu->getItems();
	}
}