@php
$authid = Auth::id();
$salesdata = DB::table('permissions')
    ->where('head', 'Sales')
    ->where('user_id', $authid)
    ->pluck('name')
    ->toArray();
$purchasedata = DB::table('permissions')
    ->where('head', 'Purchase')
    ->where('user_id', $authid)
    ->pluck('name')
    ->toArray();
$accountsdata = DB::table('permissions')
    ->where('head', 'Accounts')
    ->where('user_id', $authid)
    ->pluck('name')
    ->toArray();
$settingsdata = DB::table('permissions')
    ->where('head', 'Settings')
    ->where('user_id', $authid)
    ->pluck('name')
    ->toArray();
$marketingdata = DB::table('permissions')
        ->where('head', 'Marketing')
        ->where('user_id', $authid)
        ->pluck('name')
        ->toArray();
@endphp
@if (in_array('sedit', $salesdata))


    <style>
         .salesedit {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
         .salesedit {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif


@if (in_array('sdelete', $salesdata))


    <style>
        .salesdelete {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
         .salesdelete {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif


@if (in_array('pedit', $purchasedata))


    <style>
         .purchaseedit {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
         .purchaseedit {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif


@if (in_array('pdelete', $purchasedata))


    <style>
        .purchasedelete {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
        .purchasedelete {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif





@if (in_array('aedit', $accountsdata))


    <style>
        .accountsedit {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
        .accountsedit {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif



@if (in_array('adelete', $accountsdata))


    <style>
        .accountsdelete {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
        .accountsdelete {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif

@if (in_array('marketingDelete', $marketingdata))


    <style>
        .marketingdelete {
            display: inline-block;
            /* display: inline-block; */
        }

    </style>
@else


    <style>
        .marketingdelete {
            display: none;
            /* display: inline-block; */
        }

    </style>

@endif
