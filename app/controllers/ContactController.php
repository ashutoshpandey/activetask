<?php

class ContactController extends BaseController
{
/************************** json methods ***************************/

    public function dataAddContact()
    {
        $added_by_user_id = Input::get('added_by_user_id');
        $user_id = Input::get('user_id');

        if (isset($user_id) && isset($added_by_user_id)) {

            $user = User::find($user_id);
            $added_by_user = User::find($added_by_user_id);

            if (isset($user) && isset($added_by_user)) {
                $contact = new Contact();

                $contact->user_id = $user_id;
                $contact->added_by_user_id = $added_by_user_id;
                $contact->update_type = 'added';
                $contact->status = 'active';

                $contact->save();

                return array('message' => 'done');
            }
            else
                return array('message' => 'invalid');
        }
        else
            return array('message' => 'invalid');
    }

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
                            $resultArray[] = array(
                                'id' => $contact->id,
                                'user_id' => $user->id,
                                'name' => $user->first_name . ' ' . $user->last_name
                            );
                        }
                    }

                    return array('message' => 'found', 'contacts' => $resultArray);
                } else
                    return array('message' => 'empty');
            }
        } else
            return array('message' => 'invalid');
    }

    public function dataFindContactByEmail()
    {
        $userId = Input::get('userId');
        $email = Input::get('email');

        if (isset($email) && isset($userId)) {
            $user = User::where('email', '=', $email)->first();

            if (isset($user)){
                if($user->id==$userId)
                    return array('message' => 'same');
                else{
                    $contact = Contact::where('user_id', '=', $user->id)->where('added_by_user_id', '=', $userId)->first();

                    if(isset($contact))
                        return array('message' => 'exists', 'user' => $user->toArray());
                    else
                        return array('message' => 'found', 'user' => $user->toArray());
                }
            }
            else
                return array('message' => 'n/a');
        }
        else
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