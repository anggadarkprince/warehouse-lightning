<?php

namespace App\Policies;

use App\Models\DocumentType;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission(Permission::DOCUMENT_TYPE_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\DocumentType  $documentType
     * @return mixed
     */
    public function view(User $user, DocumentType $documentType)
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission(Permission::DOCUMENT_TYPE_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\DocumentType  $documentType
     * @return mixed
     */
    public function update(User $user, DocumentType $documentType)
    {
        return $user->hasPermission(Permission::DOCUMENT_TYPE_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\DocumentType  $documentType
     * @return mixed
     */
    public function delete(User $user, DocumentType $documentType)
    {
        return $user->hasPermission(Permission::DOCUMENT_TYPE_DELETE);
    }
}
