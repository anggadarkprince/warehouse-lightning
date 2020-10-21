<div id="modal-delete" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl delete-title">Delete</h3>
        </div>
        <form action="{{ url()->current() }}" method="post" class="pt-3">
            @csrf
            @method('delete')
            <p class="text-xl">
                Are you sure want to delete <span class="delete-label text-red-500"></span>?
            </p>
            <p class="mb-4 text-gray-400 text-sm">
                All related data could be deleted and this action might be irreversible.
            </p>
            <div class="border-t border-gray-200 text-right pt-4">
                <button type="button" class="button-light button-sm dismiss-modal px-5">Close</button>
                <button type="submit" class="button-red button-sm px-5">Delete</button>
            </div>
        </form>
    </div>
</div>
