<?php

class GroupController extends BaseController
{

    public function create()
    {
        return View::make('group.create');
    }

    public function save()
    {
        $user_id = Session::get('user');

        $name = Input::get('name');

        $userGroup = new UserGroup();

        $userGroup->name = $name;
        $userGroup->user_id = $user_id;
        $userGroup->status = 'active';

        $userGroup->save();

        echo 'created';
    }

    public function find($id)
    {
        $userGroup = UserGroup::find($id);

        if (isset($userGroup))
            return $userGroup;
        else
            return null;
    }

    public function edit($id)
    {

        $userGroup = UserGroup::find($id);

        if (isset($userGroup)) {
            Session::put('edit_user_group_id', $id);

            return View::make('UserGroup.edit')->with('UserGroup', $userGroup)->with('found', true);
        } else
            return View::make('UserGroup.edit')->with('found', false);
    }

    public function update()
    {
        $group_id = Session::get('edit_user_group_id');

        $userGroup = UserGroup::find($group_id);

        if (isset($userGroup)) {
            $name = Input::get('name');

            $userGroup->name = $name;
            $userGroup->status = 'active';

            $userGroup->save();

            echo 'updated';
        } else
            echo 'invalid';
    }

    public function all()
    {
        return View::make('group.all');
    }

    public function allGroups()
    {
        $userGroups = UserGroup::where('status', '=', 'active')->get();

        return $userGroups;
    }

    public function removeGroup($id)
    {
        $userGroup = UserGroup::find($id);

        if (isset($userGroup)) {
            $userGroup->status = 'removed';

            $userGroup->save();

            echo 'removed';
        } else
            echo 'invalid';
    }

    public function removeGroups()
    {
        $ids = Input::get('ids'); // comma separated ids, to be removed

        if (isset($ids)) {

            $ar_ids = explode(',', $ids);

            if (isset($ar_ids)) {

                foreach ($ar_ids as $id) {

                    UserGroup::where('id', '=', $id)->delete();
                }

                echo 'removed';
            }
        } else
            echo 'invalid';
    }

    public function removeGroupMember($id)
    {
        $groupMember = GroupMember::find($id);

        if (isset($groupMember)) {
            $groupMember->status = 'removed';

            $groupMember->save();

            echo 'removed';
        } else
            echo 'invalid';
    }

    public function removeGroupMembers()
    {
        $ids = Input::get('ids'); // comma separated ids, to be removed

        if (isset($ids)) {

            $ar_ids = explode(',', $ids);

            if (isset($ar_ids)) {

                foreach ($ar_ids as $id) {

                    GroupMember::where('id', '=', $id)->delete();
                }

                echo 'removed';
            }
        } else
            echo 'invalid';
    }

    public function groupMembers($id)
    {

        $group = UserGroup::find($id);

        if (isset($group)) {

            Session::put('member_group_id', $id);

            $groupMembers = GroupMember::where('group_id', '=', $id)->where('status', '=', 'active')->get();

            $found = isset($groupMembers) && count($groupMembers) > 0;

            return View::make('group.group-members')->with('found', $found);
        } else {
            return View::make('group.group-members')->with('found', false);
        }
    }

    public function allGroupMembers()
    {
        $group_id = Session::get('member_group_id');

        if (isset($group_id)) {
            $groupMembers = GroupMember::where('status', '=', 'active')->where('group_id', '=', $group_id)->with('user')->get();

            if (isset($groupMembers) && count($groupMembers) > 0)
                return $groupMembers;
            else
                return array();
        } else
            return array();
    }

    public function saveGroupMember()
    {
        $group_id = Session::get('member_group_id'); // the group in which to add member

        $member_id = Input::get('id');

        $groupMember = new GroupMember();

        $groupMember->user_id = $member_id;
        $groupMember->group_id = $group_id;
        $groupMember->status = 'pending';

        $groupMember->save();

        echo 'created';
    }

    /************************** json methods ***************************/

    public function dataAllGroups($id)
    {
        if (isset($id)) {

            $user = User::find($id);

            if (isset($user)) {
                $groups = UserGroup::where('status', '=', 'active')->where('user_id', $id)->get();

                if (isset($groups) && count($groups) > 0)
                    return array('message' => 'found', 'groups' => $groups->toArray());
                else
                    return array('message' => 'empty');
            } else
                return array('message' => 'invalid');
        } else
            return array('message' => 'invalid');
    }

    public function dataAllGroupsCount($id)
    {
        if (isset($id)) {

            $user = User::find($id);

            if (isset($user)) {
                $count = UserGroup::where('status', '=', 'active')->where('user_id', $id)->count();

                return array('count' => $count);
            } else
                return array('count' => 0);
        } else
            return array('count' => 0);
    }

    public function dataAllGroupMembers($groupId)
    {
        if (isset($groupId)) {
            $group = UserGroup::find($groupId);

            if (isset($group)) {
                $groupMembers = GroupMember::where('status', '=', 'active')->where('group_id', '=', $groupId)->with('userGroup')->get();

                if (isset($groupMembers) && count($groupMembers) > 0) {

                    $resultArray = array();

                    foreach ($groupMembers as $groupMember) {
                        $user = User::find($groupMember->user_id);

                        if (isset($user)) {
                            $resultArray[] = array('id' => $groupMember->id, 'name' => $user->first_name . ' ' . $user->last_name);
                        }
                    }

                    return array('message' => 'found', 'groupMembers' => $resultArray);
                } else
                    return array('message' => 'empty');
            }
        } else
            return array('message' => 'invalid');
    }

    public function dataRemoveGroupMembers($userId)
    {
        if (isset($userId)) {
            $user = User::find($userId);

            if (isset($user)) {

                $ids = Input::get('ids'); // comma separated ids, to be removed

                if (isset($ids)) {

                    $ar_ids = explode(',', $ids);

                    if (isset($ar_ids)) {

                        foreach ($ar_ids as $id) {

                            GroupMember::where('id', '=', $id)->delete();
                        }

                        echo 'removed';
                    }
                } else
                    echo 'invalid session';
            }
        }
    }
}