<!-- resources/views/components/delete-modal.blade.php -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg p-6">
      <h3 class="text-lg font-semibold mb-4">Confirm Deletion</h3>
      <p>Are you sure you want to delete this ?</p>
      <div class="flex justify-end mt-4">
          <button id="cancelButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
              Cancel
          </button>
          <form id="deleteForm" action="" method="POST" class="ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">
                  Delete
              </button>
          </form>
      </div>
  </div>
</div>

<script>
  function openDeleteModal(actionUrl) {
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteForm').action = actionUrl;
  }

  document.getElementById('cancelButton').onclick = function() {
      document.getElementById('deleteModal').classList.add('hidden');
  }
</script>
