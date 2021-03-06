<?php

namespace Model;

class Permission  extends \DB\SQL\Mapper {
	const MY_CLAN_REMOVE_MEMBER = 'my_clan_remove_member';
	const MY_CLAN_INVITE_PLAYER = 'my_clan_invite_member';
	const MY_CLAN_CHANGE_LEADER = 'my_clan_change_leader';
	const MY_CLAN_HANDLE_MEMBERSHIP_REQUEST = 'my_clan_handle_membership_request';
	const MY_CLAN_EDIT_DETAILS = 'my_clan_edit_details';

	// Instantiate mapper
	function __construct( \DB\SQL $db ) {
		// This is where the mapper and DB structure synchronization occurs
		parent::__construct( $db, 'clan_members');
	}

	# TODO: imeplement better perm system
	function getPerms($player_id) {
		$member = $this->load(array('player_id = ?', $player_id));
		$perm = false;
		if(!$this->dry()) {
			$perm = ($this->clan_rank == 'ACU') ? 'true' : 'false';
		}
		return array(self::MY_CLAN_REMOVE_MEMBER => $perm,
					self::MY_CLAN_INVITE_PLAYER => $perm,
					self::MY_CLAN_CHANGE_LEADER => $perm,
					self::MY_CLAN_HANDLE_MEMBERSHIP_REQUEST => $perm,
					self::MY_CLAN_EDIT_DETAILS => $perm);
	}
	
	function hasPerm($player_id, $perm) {
		$this->load(array('player_id = ?', $player_id));
		if($this->dry()) {
			return FALSE;
		}
		return  $this->clan_rank == 'ACU';
	}
}
