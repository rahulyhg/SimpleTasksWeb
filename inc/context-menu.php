<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/15/17
 * Time: 7:41 PM
 */
?>
<!-- Custom context menu -->
<nav id="context-menu" class="context-menu">
    <ul class="context-menu__items">
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="View">
                <i class="fa fa-eye text-success"></i> View Task
            </a>
        </li>

        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Edit">
                <i class="fa fa-edit text-success"></i> Edit Task
            </a>
        </li>

        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Mark">
                <i class="fa fa-check text-success"></i> Mark Task
            </a>
        </li>

        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Delete">
                <i class="fa fa-times text-danger"></i> Delete Task
            </a>
        </li>
    </ul>
</nav>

<script src="/js/context-menu.js"></script>
<script>
    //Add event for when a user wants to view an item through the context menu
    document.addEventListener("onTaskView", function()
    {
        window.location.href = "view.php?item=" + contextMenu.taskItemInContext.getAttribute("data-id");
    });

    //Add event listener for when a user wants to edit an item through the context menu
    document.addEventListener("onTaskEdit", function()
    {
        //Find the current task
        var itemText = document.getElementById("item-name-" + contextMenu.taskItemInContext.getAttribute("data-id"));
        var itemInput = document.getElementById("item-name-edit-" + contextMenu.taskItemInContext.getAttribute("data-id"));
        var oldValue = itemInput.value;

        //Turn off the item display text and turn on the input
        function toggleItemTextOff()
        {
            itemText.style.display = "none";
            itemInput.style.display = "inline-block";
        }

        //Turn off the item input and turn on the input text
        function toggleItemInputOff()
        {
            itemText.style.display = "inline-block";
            itemInput.style.display = "none";
        }

        toggleItemTextOff();

        //Remove readonly and focus on element
        itemInput.readOnly = false;
        itemInput.focus();

        //Highlight all of the text in the input
        itemInput.setSelectionRange(0, itemInput.value.length);

        //Remove readonly when focus is lost
        itemInput.addEventListener("focusout", function()
        {
            itemInput.readOnly = true;
            itemInput.value = oldValue;

            toggleItemInputOff();
        });

        //Listen for the escape key to be pressed
        window.onkeyup = function(e)
        {
            if(e.keyCode === 27) //Escape key
            {
                itemInput.blur(); //Revert back the text to the old stuff
                toggleItemInputOff();
            }
        };
    });

    //Add event listener for when a user wants to mark a task
    document.addEventListener("onTaskMark", function()
    {
        window.location.href = "/procedures/mark.php?as=done&item=" + contextMenu.taskItemInContext.getAttribute("data-id");
    });

    //Add event listener for when a user wants to delete an item through the context menu
    document.addEventListener("onTaskDelete", function()
    {
        window.location.href = "/procedures/delete.php?item=" + contextMenu.taskItemInContext.getAttribute("data-id");
    });
</script>
