@extends('../layouts/' . $layout)

@section('subhead')
    <title>Dashboard</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">General Report</h2>
                        <a
                            class="ml-auto flex items-center text-primary"
                            href=""
                        >
                            <x-base.lucide
                                class="mr-3 h-4 w-4"
                                icon="RefreshCcw"
                            /> Reload Data
                        </a>
                    </div>
                    <div class="mt-5 grid grid-cols-12 gap-6">
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-primary"
                                            icon="building-2"
                                        />
                                        {{-- <div class="ml-auto">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="33% Higher than last month"
                                            >
                                                33%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">105</div>
                                    <div class="mt-1 text-base text-slate-500">Inmuebles </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-pending"
                                            icon="settings"
                                        />
                                       {{--  <div class="ml-auto">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-danger py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="2% Lower than last month"
                                            >
                                                2%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronDown"
                                                />
                                            </x-base.tippy>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">326</div>
                                    <div class="mt-1 text-base text-slate-500">Equipos</div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-warning"
                                            icon="wrench"
                                        />
                                        {{-- <div class="ml-auto">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="12% Higher than last month"
                                            >
                                                12%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">0</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Mant. Pendientes
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-success"
                                            icon="shield-check"
                                        />
                                    {{--     <div class="ml-auto">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="22% Higher than last month"
                                            >
                                                22%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">0</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Garantías Activas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
               {{--  <div class="col-span-12 mt-8 lg:col-span-6">
                    <div class="intro-y block h-10 items-center sm:flex">
                        <h2 class="mr-5 truncate text-lg font-medium">Sales Report</h2>
                        <div class="relative mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                            <x-base.lucide
                                class="absolute inset-y-0 left-0 z-10 my-auto ml-3 h-4 w-4"
                                icon="Calendar"
                            />
                            <x-base.litepicker
                                class="datepicker !box pl-10 sm:w-56"
                                type="text"
                            />
                        </div>
                    </div>
                    <div class="intro-y box mt-12 p-5 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                                        $15,000
                                    </div>
                                    <div class="mt-0.5 text-slate-500">This Month</div>
                                </div>
                                <div
                                    class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                                </div>
                                <div>
                                    <div class="text-lg font-medium text-slate-500 xl:text-xl">
                                        $10,000
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Last Month</div>
                                </div>
                            </div>
                            <x-base.menu class="mt-5 md:ml-auto md:mt-0">
                                <x-base.menu.button
                                    class="font-normal"
                                    as="x-base.button"
                                    variant="outline-secondary"
                                >
                                    Filter by Category
                                    <x-base.lucide
                                        class="ml-2 h-4 w-4"
                                        icon="ChevronDown"
                                    />
                                </x-base.menu.button>
                                <x-base.menu.items class="h-32 w-40 overflow-y-auto">
                                    <x-base.menu.item>PC & Laptop</x-base.menu.item>
                                    <x-base.menu.item>Smartphone</x-base.menu.item>
                                    <x-base.menu.item>Electronic</x-base.menu.item>
                                    <x-base.menu.item>Photography</x-base.menu.item>
                                    <x-base.menu.item>Sport</x-base.menu.item>
                                </x-base.menu.items>
                            </x-base.menu>
                        </div>
                        <div @class([
                            'relative',
                            'before:content-[\'\'] before:block before:absolute before:w-16 before:left-0 before:top-0 before:bottom-0 before:ml-10 before:mb-7 before:bg-gradient-to-r before:from-white before:via-white/80 before:to-transparent before:dark:from-darkmode-600',
                            'after:content-[\'\'] after:block after:absolute after:w-16 after:right-0 after:top-0 after:bottom-0 after:mb-7 after:bg-gradient-to-l after:from-white after:via-white/80 after:to-transparent after:dark:from-darkmode-600',
                        ])>
                            <x-report-line-chart
                                class="mt-6 -mb-6"
                                height="h-[275px]"
                            />
                        </div>
                    </div>
                </div> --}}
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Top Seller -->
               {{--  <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Weekly Top Seller</h2>
                        <a
                            class="ml-auto truncate text-primary"
                            href=""
                        > Show More </a>
                    </div>
                    <div class="intro-y box mt-5 p-5">
                        <div class="mt-3">
                            <x-report-pie-chart height="h-[213px]" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                                <span class="truncate">17 - 30 Years old</span>
                                <span class="ml-auto font-medium">62%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                                <span class="truncate">31 - 50 Years old</span>
                                <span class="ml-auto font-medium">33%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                                <span class="truncate">&gt;= 50 Years old</span>
                                <span class="ml-auto font-medium">10%</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Sales Report -->
                {{-- <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Sales Report</h2>
                        <a
                            class="ml-auto truncate text-primary"
                            href=""
                        > Show More </a>
                    </div>
                    <div class="intro-y box mt-5 p-5">
                        <div class="mt-3">
                            <x-report-donut-chart height="h-[213px]" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                                <span class="truncate">17 - 30 Years old</span>
                                <span class="ml-auto font-medium">62%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                                <span class="truncate">31 - 50 Years old</span>
                                <span class="ml-auto font-medium">33%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                                <span class="truncate">&gt;= 50 Years old</span>
                                <span class="ml-auto font-medium">10%</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Sales Report -->
                <!-- BEGIN: Official Store -->
                {{-- <div class="col-span-12 mt-6 xl:col-span-8">
                    <div class="intro-y block h-10 items-center sm:flex">
                        <h2 class="mr-5 truncate text-lg font-medium">Official Store</h2>
                        <div class="relative mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                            <x-base.lucide
                                class="absolute inset-y-0 left-0 z-10 my-auto ml-3 h-4 w-4"
                                icon="MapPin"
                            />
                            <x-base.form-input
                                class="!box pl-10 sm:w-56"
                                type="text"
                                placeholder="Filter by city"
                            />
                        </div>
                    </div>
                    <div class="intro-y box mt-12 p-5 sm:mt-5">
                        <div>
                            250 Official stores in 21 countries, click the marker to see
                            location details.
                        </div>
                        <x-leaflet-map class="mt-5 h-[310px] rounded-md bg-slate-200" />
                    </div>
                </div> --}}
                <!-- END: Official Store -->
                <!-- BEGIN: Weekly Best Sellers -->
               {{--  <div class="col-span-12 mt-6 xl:col-span-4">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">
                            Weekly Best Sellers
                        </h2>
                    </div>
                    <div class="mt-5">
                        @foreach (array_slice($fakers, 0, 4) as $faker)
                            <div class="intro-y">
                                <div class="box zoom-in mb-3 flex items-center px-4 py-4">
                                    <div class="image-fit h-10 w-10 flex-none overflow-hidden rounded-md">
                                        <img
                                            src="{{ Vite::asset($faker['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{ $faker['users'][0]['name'] }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            {{ $faker['dates'][0] }}
                                        </div>
                                    </div>
                                    <div
                                        class="cursor-pointer rounded-full bg-success px-2 py-1 text-xs font-medium text-white">
                                        137 Sales
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <a
                            class="intro-y block w-full rounded-md border border-dotted border-slate-400 py-4 text-center text-slate-500 dark:border-darkmode-300"
                            href=""
                        >
                            View More
                        </a>
                    </div>
                </div> --}}
                <!-- END: Weekly Best Sellers -->
                <!-- BEGIN: General Report -->
               {{--  <div class="col-span-12 mt-8 grid grid-cols-12 gap-6">
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                        <div class="box zoom-in p-5">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="truncate text-lg font-medium">Target Sales</div>
                                    <div class="mt-1 text-slate-500">300 Sales</div>
                                </div>
                                <div class="relative ml-auto flex-none">
                                    <x-report-donut-chart-1
                                        width="w-[90px]"
                                        height="h-[90px]"
                                    />
                                    <div
                                        class="absolute top-0 left-0 flex h-full w-full items-center justify-center font-medium">
                                        20%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                        <div class="box zoom-in p-5">
                            <div class="flex">
                                <div class="mr-3 truncate text-lg font-medium">
                                    Social Media
                                </div>
                                <div
                                    class="ml-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400">
                                    320 Followers
                                </div>
                            </div>
                            <div class="mt-1">
                                <x-simple-line-chart-1
                                    class="-ml-1"
                                    height="h-[58px]"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                        <div class="box zoom-in p-5">
                            <div class="flex items-center">
                                <div class="w-2/4 flex-none">
                                    <div class="truncate text-lg font-medium">New Products</div>
                                    <div class="mt-1 text-slate-500">1450 Products</div>
                                </div>
                                <div class="relative ml-auto flex-none">
                                    <x-report-donut-chart-1
                                        width="w-[90px]"
                                        height="h-[90px]"
                                    />
                                    <div
                                        class="absolute top-0 left-0 flex h-full w-full items-center justify-center font-medium">
                                        45%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                        <div class="box zoom-in p-5">
                            <div class="flex">
                                <div class="mr-3 truncate text-lg font-medium">Posted Ads</div>
                                <div
                                    class="ml-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400">
                                    180 Campaign
                                </div>
                            </div>
                            <div class="mt-1">
                                <x-simple-line-chart-1
                                    class="-ml-1"
                                    height="h-[58px]"
                                />
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: General Report -->
                <!-- BEGIN: Weekly Top Products -->
               {{--  <div class="col-span-12 mt-6">
                    <div class="intro-y block h-10 items-center sm:flex">
                        <h2 class="mr-5 truncate text-lg font-medium">
                            Weekly Top Products
                        </h2>
                        <div class="mt-3 flex items-center sm:ml-auto sm:mt-0">
                            <x-base.button class="!box flex items-center text-slate-600 dark:text-slate-300">
                                <x-base.lucide
                                    class="mr-2 hidden h-4 w-4 sm:block"
                                    icon="FileText"
                                />
                                Export to Excel
                            </x-base.button>
                            <x-base.button class="!box ml-3 flex items-center text-slate-600 dark:text-slate-300">
                                <x-base.lucide
                                    class="mr-2 hidden h-4 w-4 sm:block"
                                    icon="FileText"
                                />
                                Export to PDF
                            </x-base.button>
                        </div>
                    </div>
                    <div class="intro-y mt-8 overflow-auto sm:mt-0 lg:overflow-visible">
                        <x-base.table class="border-separate border-spacing-y-[10px] sm:mt-2">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        IMAGES
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0">
                                        PRODUCT NAME
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        STOCK
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        STATUS
                                    </x-base.table.th>
                                    <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                        ACTIONS
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                @foreach (array_slice($fakers, 0, 4) as $faker)
                                    <x-base.table.tr class="intro-x">
                                        <x-base.table.td
                                            class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <div class="flex">
                                                <div class="image-fit zoom-in h-10 w-10">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['images'][0]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][0] }}"
                                                    />
                                                </div>
                                                <div class="image-fit zoom-in -ml-5 h-10 w-10">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['photos'][1]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][1] }}"
                                                    />
                                                </div>
                                                <div class="image-fit zoom-in -ml-5 h-10 w-10">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['photos'][2]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][2] }}"
                                                    />
                                                </div>
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <a
                                                class="whitespace-nowrap font-medium"
                                                href=""
                                            >
                                                {{ $faker['products'][0]['name'] }}
                                            </a>
                                            <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                                {{ $faker['products'][0]['category'] }}
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            {{ $faker['stocks'][0] }}
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <div @class([
                                                'flex items-center justify-center',
                                                'text-success' => $faker['true_false'][0],
                                                'text-danger' => !$faker['true_false'][0],
                                            ])>
                                                <x-base.lucide
                                                    class="mr-2 h-4 w-4"
                                                    icon="CheckSquare"
                                                />
                                                {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400"
                                        >
                                            <div class="flex items-center justify-center">
                                                <a
                                                    class="mr-3 flex items-center"
                                                    href=""
                                                >
                                                    <x-base.lucide
                                                        class="mr-1 h-4 w-4"
                                                        icon="CheckSquare"
                                                    />
                                                    Edit
                                                </a>
                                                <a
                                                    class="flex items-center text-danger"
                                                    href=""
                                                >
                                                    <x-base.lucide
                                                        class="mr-1 h-4 w-4"
                                                        icon="Trash"
                                                    />
                                                    Delete
                                                </a>
                                            </div>
                                        </x-base.table.td>
                                    </x-base.table.tr>
                                @endforeach
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                    <div class="intro-y mt-3 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronsLeft"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronLeft"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>...</x-base.pagination.link>
                            <x-base.pagination.link>1</x-base.pagination.link>
                            <x-base.pagination.link active>2</x-base.pagination.link>
                            <x-base.pagination.link>3</x-base.pagination.link>
                            <x-base.pagination.link>...</x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronRight"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="h-4 w-4"
                                    icon="ChevronsRight"
                                />
                            </x-base.pagination.link>
                        </x-base.pagination>
                        <x-base.form-select class="!box mt-3 w-20 sm:mt-0">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </x-base.form-select>
                    </div>
                </div> --}}
                <!-- END: Weekly Top Products -->
            </div>
        </div>
      
            <div class="-mb-10 pb-10 2xl:border-l">
                <div class="grid grid-cols-12 gap-x-6 gap-y-6 2xl:gap-x-0 2xl:pl-6">
                   
                </div>
            </div>
       
    </div>
@endsection
