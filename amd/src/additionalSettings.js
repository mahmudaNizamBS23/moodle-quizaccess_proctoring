define(['jquery', 'core/ajax', 'core/notification'],
    function($) {
        return {
            setup: function () {

                $("#select_all").click(function () {
                    const checkBox = document.getElementById("select_all");
                    const btn = document.getElementById("delete_select_btn");
                    if (checkBox.checked === true) {
                        btn.style.display = "block";
                        $(".reportIdChkBox").prop('checked', true);
                    } else {
                        btn.style.display = "none";
                        $(".reportIdChkBox").prop('checked', false);
                    }

                    refreshDeleteIdStringValue();
                });

                $(".reportIdChkBox").click(function () {
                    const btn = document.getElementById("delete_select_btn");

                    const checkBoxArray = document.getElementsByClassName('reportIdChkBox');
                    let anychecked = false;
                    
                    for (const element of checkBoxArray) {
                        anychecked = element.checked;
                    }
                    
                    if (anychecked) {
                        btn.style.display = "block";
                    } else {
                        btn.style.display = "none";
                    }

                    refreshDeleteIdStringValue();
                });

                function refreshDeleteIdStringValue() {
                    const idArray = [];
                    const checkBoxArray = document.getElementsByClassName('reportIdChkBox');
                    
                    for (const element of checkBoxArray) {
                        if (element.checked) {
                            idArray.push(element.value);
                        }
                    }
                    
                    const idString = idArray.join();
                    document.getElementById('deleteidstring').value = idString;
                }

                return true;
            }
        };
    });
