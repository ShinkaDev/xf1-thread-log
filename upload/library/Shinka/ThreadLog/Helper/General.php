<?php

/*
	Copyright (c) Siropu
	This is a PREMIUM PAID Add-on. If you obtained this copy illegally, please go to https://www.siropu.com/ and purchase a licence to get the latest version and to receive support.

	Referral Contests Add-on by Siropu
	XenForo Profile: https://xenforo.com/community/members/siropu.92813/
	Website: https://www.siropu.com/
	Contact: contact@siropu.com
*/

class Shinka_ThreadLog_Helper_General
{
	public static function userHasPermission($permission)
	{
		$permissions = XenForo_Visitor::getInstance()->getPermissions();
		return XenForo_Permission::hasPermission($permissions, 'shinkaThreadLog', $permission);
	}
}
