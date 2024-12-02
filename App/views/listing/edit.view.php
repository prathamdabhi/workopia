<?php
loadpartial('head');
?>
<!-- Nav -->
<?php loadpartial('navbar') ?>
<!-- Top Banner -->
<?php loadpartial('topBanner') ?>

<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>

        <form method="POST" action="/listings/<?= $listing['id'] ?>">
            <input type="hidden" name="_method" value="PUT">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>
            <?= loadpartial('error', [
                "error" => $error ?? []
            ]) ?>
            <div class="mb-4">
                <input
                    type="text"
                    name="title"
                    placeholder="Job Title"
                    value="<?= $listing['title'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <textarea
                    name="description"
                    placeholder="Job Description"

                    class="w-full px-4 py-2 border rounded focus:outline-none"><?= $listing['description'] ?? "" ?></textarea>
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="salary"
                    placeholder="Annual Salary"
                    value="<?= $listing['salary'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="requirements"
                    placeholder="Requirements"
                    value="<?= $listing['requirements'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="benefits"
                    placeholder="Benefits"
                    value="<?= $listing['benefits'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info & Location
            </h2>
            <div class="mb-4">
                <input
                    type="text"
                    name="company"
                    placeholder="Company Name"
                    value="<?= $listing['company'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="address"
                    placeholder="Address"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="city"
                    placeholder="City"
                    value="<?= $listing['city'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="state"
                    placeholder="State"
                    value="<?= $listing['state'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    name="phone"
                    placeholder="Phone"
                    value="<?= $listing['phone'] ?? "" ?>"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input
                    type="email"
                    name="email"
                    value="<?= $listing['email'] ?? "" ?>"
                    placeholder="Email Address For Applications"
                    class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <button
                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Update
            </button>
            <!-- <a
                href="/listings/<?= $listing['id'] ?>"
                class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
                Cancel
            </a> -->
        </form>
    </div>
</section>

<?php loadpartial('bottomBanner') ?>

<?php loadpartial('footer') ?>