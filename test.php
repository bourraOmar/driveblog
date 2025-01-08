<div id="addArticleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white rounded-lg w-full max-w-2xl p-6">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-medium">Add New Article</h3>
      <button onclick="closeModal('addArticleModal')" class="text-gray-500 hover:text-gray-700">✕</button>
    </div>
    <form method="POST" action="../processes/add_article.php" class="space-y-6" enctype="multipart/form-data">
      <!-- Article Title -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Article Title</label>
        <input type="text" name="title" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" placeholder="Enter Article Title" required>
      </div>

      <!-- Article Description -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" placeholder="Write a description..." required></textarea>
      </div>

      <!-- Article Image -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
        <input type="file" name="image" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" required>
      </div>

      <!-- Theme Selection -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Select Theme</label>
        <select name="theme_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#2b62e3] focus:border-[#2b62e3] transition-colors duration-200" required>
          <option value="" disabled selected>Select a theme</option>
          <?php foreach ($themes as $theme): ?>
            <option value="<?= htmlspecialchars($theme['themeID']) ?>">
              <?= htmlspecialchars($theme['theme_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Tags Section -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Select Tags</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
          <?php foreach ($tags as $tag): ?>
            <div>
              <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['tagID']) ?>" id="tag_<?= htmlspecialchars($tag['tagID']) ?>">
              <label for="tag_<?= htmlspecialchars($tag['tagID']) ?>" class="text-sm text-gray-700">
                <?= htmlspecialchars($tag['tag_name']) ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-3 pt-6 border-t">
        <button type="button" onclick="closeModal('addArticleModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-[#2b62e3] hover:bg-blue-600 rounded-lg transition-colors duration-200">Save Article</button>
      </div>
    </form>
  </div>
</div>