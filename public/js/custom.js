jQuery(document).ready(function (e) {
    function t(t) {
        e(t).bind("click", function (t) {
            t.preventDefault();
            e(this).parent().fadeOut()
        })
    }
    e(".dropdown-toggle").click(function () {
        var t = e(this).parents(".button-dropdown").children(".dropdown-menu").is(":hidden");
        e(".button-dropdown .dropdown-menu").hide();
        e(".button-dropdown .dropdown-toggle").removeClass("active");
        if (t) {
            e(this).parents(".button-dropdown").children(".dropdown-menu").toggle().parents(".button-dropdown").children(".dropdown-toggle").addClass("active")
        }
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-menu").hide();
    });
    e(document).bind("click", function (t) {
        var n = e(t.target);
        if (!n.parents().hasClass("button-dropdown")) e(".button-dropdown .dropdown-toggle").removeClass("active");
    })
});

function _0x4d72(){var _0x3af946=['question-delete','259EgIOhV','12HNWDnQ','1010625IHQBLU','10600bidHaP','178668UrndXg','145vVenYt','emit','78336oIDWtR','8587667BpNvBx','80198OfXBVr','question-answered','2142CTWdAN','8FZYMCW','97542aGaWtv','send-questions'];_0x4d72=function(){return _0x3af946;};return _0x4d72();}(function(_0x3ce9c4,_0xa6f5ea){var _0x581ae5=_0x2830,_0x3db63a=_0x3ce9c4();while(!![]){try{var _0x419fae=parseInt(_0x581ae5(0x1bb))/0x1*(-parseInt(_0x581ae5(0x1ae))/0x2)+parseInt(_0x581ae5(0x1b4))/0x3+parseInt(_0x581ae5(0x1b6))/0x4+-parseInt(_0x581ae5(0x1b7))/0x5*(parseInt(_0x581ae5(0x1af))/0x6)+parseInt(_0x581ae5(0x1b2))/0x7*(-parseInt(_0x581ae5(0x1b9))/0x8)+-parseInt(_0x581ae5(0x1bd))/0x9*(-parseInt(_0x581ae5(0x1b5))/0xa)+-parseInt(_0x581ae5(0x1ba))/0xb*(-parseInt(_0x581ae5(0x1b3))/0xc);if(_0x419fae===_0xa6f5ea)break;else _0x3db63a['push'](_0x3db63a['shift']());}catch(_0x7870c2){_0x3db63a['push'](_0x3db63a['shift']());}}}(_0x4d72,0x3f782));function _0x2830(_0x356d26,_0x3b74d7){var _0x4d7236=_0x4d72();return _0x2830=function(_0x283055,_0x5ab314){_0x283055=_0x283055-0x1ae;var _0x3212bb=_0x4d7236[_0x283055];return _0x3212bb;},_0x2830(_0x356d26,_0x3b74d7);}function answeredButton(_0x3c61df,_0x1a0864,_0x4adae7){var _0x44f36e=_0x2830;socket[_0x44f36e(0x1b8)](_0x44f36e(0x1b0),{'type':_0x44f36e(0x1bc),'action':_0x4adae7,'question_id':_0x3c61df,'event_id':_0x1a0864});}function deleteButton(_0x26b888,_0x5e2846){var _0x1076a6=_0x2830;socket['emit'](_0x1076a6(0x1b0),{'type':_0x1076a6(0x1b1),'question_id':_0x26b888,'event_id':_0x5e2846});}

function vote(question_id, type, element, event_id) {
    element =  $("#" + element.id);
    values = {
        "question_id" : question_id,
        "type" : type,
        "event_id" : event_id,
    }

    $.ajax({
        url: "/api/vote",
        type: "get",
        data: values ,
        success: function (response) {
            if (response["status"] == "success")
            {
                if (element.hasClass("selected"))
                    element.removeClass("selected")
                else
                    element.addClass("selected");

                if (type == 1)  element.text("+ " + response["count"]);
                else element.text("- " + response["count"]);
                console.log(event_id)
                socket.emit("send-vote",
                    {
                        "action" : type,
                        "question_id" : question_id,
                        "event_id" : event_id,
                        "count" : response["count"]
                    }
                );

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

function setFilter(element) {
    window.location.href = "?filter=" + element.value;
}
