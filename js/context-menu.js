/**
 * Variables.
 */
var contextMenu = {
    viewTaskEvent : null,
    editTaskEvent: null,
    markTaskEvent: null,
    deleteTaskEvent: null,

    contextMenuClassName : "context-menu",
    contextMenuItemClassName : "context-menu__item",
    contextMenuLinkClassName : "context-menu__link",
    contextMenuActive : "context-menu--active",

    taskItemClassName : "item",
    taskItemInContext : null,

    clickCoords : null,
    clickCoordsX : 0,
    clickCoordsY : 0,

    menu : null,
    menuItems : null,
    menuState : 0,
    menuWidth : 0,
    menuHeight : 0,
    menuPosition : null,
    menuPositionX : 0,
    menuPositionY : 0,

    windowWidth : 0,
    windowHeight : 0
};

(function()
{
    "use strict";

    ///////////////////////////////////////
    ///////////////////////////////////////
    //
    // H E L P E R    F U N C T I O N S
    //
    ///////////////////////////////////////
    ///////////////////////////////////////

    /**
     * Checks if the mouse cursor is on a task item.
     */
    function clickInsideElement(e, className)
    {
        var el = e.srcElement || e.target;

        if(el.classList.contains((className)))
        {
            return el;
        }
        else
        {
            while(el = el.parentNode)
            {
                if(el.classList && el.classList.contains((className)))
                {
                    return el;
                }
            }
        }

        return false;
    }

    /**
     * Finds and returns the position of the mouse cursor.
     */
    function getPosition(e)
    {
        var posX = 0;
        var posY = 0;

        if(!e)
        {
            e = window.event;
        }

        if(e.pageX || e.pageY)
        {
            posX = e.pageX;
            posY = e.pageY;
        }
        else if(e.clientX || e.clientY)
        {
            posX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }

        return {
            x: posX,
            y: posY
        }
    }

    ///////////////////////////////////////
    ///////////////////////////////////////
    //
    // C O R E    F U N C T I O N S
    //
    ///////////////////////////////////////
    ///////////////////////////////////////

    /**
     * Set up variables past their base values
     */
    contextMenu.viewTaskEvent = new Event("onTaskView");
    contextMenu.editTaskEvent = new Event("onTaskEdit");
    contextMenu.markTaskEvent = new Event("onTaskMark");
    contextMenu.deleteTaskEvent = new Event("onTaskDelete");

    contextMenu.menu = document.querySelector("#context-menu");
    contextMenu.menuItems = contextMenu.menu.querySelectorAll(".context-menu__item");

    /**
     * Initialize our application's code.
     */
    function init()
    {
        contextListener();
        clickListener();
        keyupListener();
        resizeListener();
    }

    /**
     * Listens for contextmenu events.
     */
    function contextListener()
    {
        document.addEventListener("contextmenu", function(e)
        {
            contextMenu.taskItemInContext = clickInsideElement(e, contextMenu.taskItemClassName);

            if(contextMenu.taskItemInContext)
            {
                e.preventDefault();
                toggleMenuOn();
                positionMenu(e);
            }
            else
            {
                contextMenu.taskItemInContext = null;
                toggleMenuOff();
            }
        });
    }

    /**
     * Listens for click events.
     */
    function clickListener()
    {
        document.addEventListener("click", function(e)
        {
            var clickedElIsLink = clickInsideElement(e, contextMenu.contextMenuLinkClassName);

            if(clickedElIsLink)
            {
                e.preventDefault();
                menuItemListener(clickedElIsLink);
            }
            else
            {
                var button = e.which || e.button;
                if(button === 1)
                {
                    toggleMenuOff();
                }
            }
        });
    }

    /**
     * Listens for keyup events.
     */
    function keyupListener()
    {
        window.onkeyup = function(e)
        {
            if(e.keyCode === 27) //Escape key
            {
                toggleMenuOff();
            }
        };
    }

    /**
     * Listens for resize events.
     */
    function resizeListener()
    {
        window.onresize = function(e)
        {
            toggleMenuOff();
        };
    }

    /**
     * Listens for when a menu item is clicked.
     */
    function menuItemListener(link)
    {
        var dataAction = link.getAttribute("data-action");

        if(dataAction === "View")
        {
            document.dispatchEvent(contextMenu.viewTaskEvent);
        }
        else if(dataAction === "Edit")
        {
            document.dispatchEvent(contextMenu.editTaskEvent);
        }
        else if(dataAction === "Mark")
        {
            document.dispatchEvent(contextMenu.markTaskEvent);
        }
        else if(dataAction === "Delete")
        {
            document.dispatchEvent(contextMenu.deleteTaskEvent);
        }

        toggleMenuOff();
    }

    /**
     * Position the context menu.
     */
    function positionMenu(e)
    {
        contextMenu.clickCoords = getPosition(e);
        contextMenu.clickCoordsX = contextMenu.clickCoords.x;
        contextMenu.clickCoordsY = contextMenu.clickCoords.y;

        contextMenu.menuWidth = contextMenu.menu.offsetWidth + 4;
        contextMenu.menuHeight = contextMenu.menu.offsetHeight + 4;

        contextMenu.windowWidth = window.innerWidth;
        contextMenu.windowHeight = window.innerHeight;

        if( (contextMenu.windowWidth - contextMenu.clickCoordsX) < contextMenu.menuWidth )
        {
            contextMenu.menu.style.left = contextMenu.windowWidth - contextMenu.menuWidth + "px";
        }
        else
        {
            contextMenu.menu.style.left = contextMenu.clickCoordsX + "px";
        }

        if( (contextMenu.windowHeight- - contextMenu.clickCoordsY) < contextMenu.menuHeight )
        {
            contextMenu.menu.style.top = contextMenu.windowHeight - contextMenu.menuHeight + "px";
        }
        else
        {
            contextMenu.menu.style.top = contextMenu.clickCoordsY + "px";
        }
    }

    /**
     * Turns the custom context menu on.
     */
    function toggleMenuOn()
    {
        if (contextMenu.menuState !== 1)
        {
            contextMenu.menuState = 1;
            contextMenu.menu.classList.add(contextMenu.contextMenuActive);
        }
    }

    /**
     * Turns the custom context menu off.
     */
    function toggleMenuOff()
    {
        if (contextMenu.menuState !== 0)
        {
            contextMenu.menuState = 0;
            contextMenu.menu.classList.remove(contextMenu.contextMenuActive);
        }
    }

    /**
     * Run the app.
     */
    init();
})();