<?php

function controller()
{ 
    $moris_donuts = [
        [
            "label" => __("Categories"),
            "value" => Category::where("parent_id", 0)->count(),
        ],
        [
            "label" => __("Stages"),
            "value" => Category::where("parent_id", ">", 0)->count(),
        ],
        [
            "label" => __("Levels"),
            "value" => Level::count(),
        ]
    ];

    $data = json_encode($moris_donuts);
    return view('admin.pages.home.index', compact('data'));
}
?>
<script>
    // in blade

       $(function(){
            const data = JSON.parse(@json($data));
            console.log(data);
       })
</script>
    