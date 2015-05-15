<?php

class ContactController extends BaseController
{
/************************** json methods ***************************/

    public function dataAllContactsCount($id)
    {
        if (isset($id)) {

            $user = User::find($id);

            if (isset($user)) {
                $count = Contact::where('status', '=', 'active')->where('user_id', $id)->count();

                return array('count' => $count);
            } else
                return array('count' => 0);
        } else
            return array('count' => 0);
    }

    public function dataAllContacts($userId)
    {
        if (isset($userId)) {
            $user = User::find($userId);

            if (isset($user)) {
                $contacts = Contact::where('status', '=', 'active')->get();

                if (isset($contacts) && count($contacts) > 0) {

                    $resultArray = array();

                    foreach ($contacts as $contact) {
                        $user = User::find($contact->user_id);

                        if (isset($user)) {
                            $resultArray[] = array('id' => $user->id, 'name' => $user->first_name . ' ' . $user->last_name);
                        }
                    }

                    return array('message' => 'found', 'contacts' => $resultArray);
                } else
                    return array('message' => 'empty');
            }
        } else
            return array('message' => 'invalid');
    }

    public function dataRemoveContacts()
    {
        $userId = Input::get('userId');
        
        if (isset($userId)) {
            $user = User::find($userId);

            if (isset($user)) {

                $ids = Input::get('ids'); // comma separated ids, to be removed

                if (isset($ids)) {

                    $ar_ids = explode(',', $ids);

                    if (isset($ar_ids)) {

                        foreach ($ar_ids as $id) {

                            Contact::where('id', '=', $id)->delete();
                        }

                        echo 'removed';
                    }
                } else
                    echo 'invalid session';
            }
        }
    }
}