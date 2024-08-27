<div>
    <div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
        <div class="flex ">
            <div class="flex max-w-max" style="">
                <div class="fi-ta-text-item inline-flex items-center gap-1.5  ">
                    <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  " style="">
                        <form>
    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <input wire:model.live="randomnumber" type="search" id="search"
               class="block w-full text-sm text-gray-900 border @if($randomnumber) border-green-300 @else border-gray-300 @endif rounded-lg bg-gray-50 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white ring-green-600 dark:focus:border-blue-500"
               placeholder="Search" required/>
        <button wire:click.prevent="showrand" type="submit"
                class="text-white absolute end-0 bottom-0 bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700">Search</button>
    </div>
</form>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
