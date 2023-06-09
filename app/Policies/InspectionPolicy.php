<?php

namespace App\Policies;

use App\Models\Inspection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionPolicy
{
    use HandlesAuthorization;

/* Determine whether the user can view any models.
*
* @param  \App\Models\User  $user
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function viewAny(User $user)
    {
        if($user->getRoleadmin())
            return true;
//        if($user->getRoleManeger())
//        {
//            if ($user->Inspections->Center->id == $user->center->id)
//                return $user->center->id;
//        }
//        if(in_array('View_inspection',$user->getpermission())) {
//            {  foreach ($user->getinspection() as $ins)
//            if ($ins->Center->id == $user->center->id)
//                return $user->center->id;
//        }

//        }
//        else
            return true;

    }

/* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  \App\Models\Inspection  $inspection
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function view(User $user, Inspection $inspection)
    {
        if($user->getRoleadmin())
            return true;

        if($user->getRoleManeger())
        {
            if ($inspection->Center->id == $user->center->id)
                return $inspection->Center->id;
        }
        if(in_array('View_inspection',$user->getpermission())) {
            if ($inspection->user->id == $user->id)
                return $inspection->user->id;
        }
        else
            return false;
    }

/* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function create(User $user)
    {

        if($user->getRoleadmin())
            return true;
//        if($user->Technical())
//            return false;
        if(in_array('Create_inspection',$user->getpermission()))
            return true;
//            if ($user->Inspections->Center->id == $user->center->id)
//                return $user->center->id;

        else
        return false;
    }

/* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  \App\Models\Inspection  $inspection
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function update(User $user, Inspection $inspection)
    {
        if($user->getRoleadmin())
            return true;

        if($user->getRoleManeger())
        {
            if ($inspection->Center->id == $user->center->id)
                return $inspection->Center->id;
        }

        if(in_array('Edit_inspection',$user->getpermission())) {
            if ($inspection->user->id == $user->id)

                return $inspection->user->id;
        }
        else
            return false;
    }

/* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  \App\Models\Inspection  $inspection
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function delete(User $user, Inspection $inspection)
    {
        if($user->getRoleadmin())
            return true;
        if($user->getRoleManeger())
        {
            if ($inspection->Center->id == $user->center->id)
                return $inspection->Center->id;
        }
        if(in_array('Delete_inspection',$user->getpermission()))
        {
            if ($inspection->user->id == $user->id)
                return $inspection->user->id;

        }
        else
            return false;
    }

/*Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  \App\Models\Inspection  $inspection
* @return \Illuminate\Auth\Access\Response|bool
*/
    public function restore(User $user, Inspection $inspection)
    {
        if($user->getRoleadmin())
            return true;
        if($user->getRoleManeger())
        {
            if ($inspection->Center->id == $user->center->id)
                return $inspection->Center->id;
        }
        if(in_array('Store_inspection',$user->getpermission()))
        {
            if ($inspection->user->id == $user->id)
                return $inspection->user->id;

        }
        else
            return false;
    }
    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inspection  $inspection
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Inspection $inspection)
    {
        if($user->getRoleadmin())
            return true;
        if($user->getRoleManeger())
        {
            if ($inspection->Center->id == $user->center->id)
                return $inspection->Center->id;
        }
        if(in_array('Delete_inspection',$user->getpermission()))
        {
//            if ($inspection->Center->id == $user->center->id)
//                return $inspection->Center->id;

            if ($inspection->user->id == $user->id)
                return $inspection->user->id;
        }
        else
            return false;
    }
}
