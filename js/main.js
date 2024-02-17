questionsArr = [
    {
       labelContent: "What do you mainly use your phone for?",
       formID: 'answerForm1',
       inputs: [
            {
                ID: "1A",
                Name: "",
                Value: "Catch-up on Netflix" 
            },
            // {
            //     ID: "1B",
            //     Name: "",
            //     Value: "Unlock the next levels on my favorite game" 
            // },
            {
                ID: "1B",
                Name: "",
                Value: "Tell the story of my life on social media (backed with pictures...)" 
            },
            {
                ID: "1C",
                Name: "",
                Value: "Read articles and browse some threads" 
            }
       ]
    },
    {
        labelContent: "What's in your pocket?",
        formID: 'answerForm2',
        inputs: [
             {
                 ID: "2A",
                 Name: "",
                 Value: "wallet and keys, that's it!" 
             },
             {
                 ID: "2B",
                 Name: "",
                 Value: "Quite a few things actually... Could use a bigger pocket!" 
             }
        ]
     },
     {
        labelContent: "What's your typical day like?",
        formID: 'answerForm3',
        inputs: [
             {
                 ID: "3A",
                 Name: "",
                 Value: "I guess I would just be at home or at the office" 
             },
             {
                 ID: "3B",
                 Name: "",
                 Value: "Running around town with limited access to power sockets!" 
             },
             {
                ID: "3C",
                Name: "",
                Value: "Just driving around" 
            }
        ]
     },
]

// for (var i = 0; i<questionsArr.length; i++) {
//     document.getElementById("chat-window").innerHTML+= '<div class="bot-interaction"><div class="interaction-bloc"><div class="question"><div class="avatar"></div><div class="qtn-bloc"><p>'+ questionsArr[i].labelContent + '</p></div></div><div class="answer"><form id="' + questionsArr[i].formID +'" action="post"></form></div></div></div>';
//     var inputsArr = questionsArr[i].inputs
//     console.log(inputsArr)
//     for (var j = 0; j<inputsArr.length; j++) {
//         $(".bot-interaction").find(".answer").find("form").append('<input id="' + inputsArr[j].ID + '" type="button" name="" value="' + inputsArr[j].Value + '" onclick="setParameters()" />')
//     }
// }

//Create an array to store each string.
// var paramArr = [];

//Create an array to store each answer.
var answersArr = [];

//Host device objects returned by server
var responseArr = [];

//Responsive design
var width = $(window).width();
var orientPortrait = null

setParameters = function() {

    event.target.classList.add("selected");

    var inputID = event.target.id;

    if (inputID === '1A' || inputID === '1B' || inputID === '1C') {
        loopThroughFormInputs('answerForm1')
    } else if (inputID === '2A' || inputID === '2B') {
        loopThroughFormInputs('answerForm2')
    } else if (inputID === '3A' || inputID === '3B' || inputID === '3C') {
        loopThroughFormInputs('answerForm3')
    }

    function loopThroughFormInputs(formId) {
        var form = document.getElementById(formId);
        var radio = form.getElementsByTagName('input')
        for (var i=0; i<radio.length; i++) {
            radio[i].disabled = true
        }
    }

    //Push parameter value into the answersArr unless array already contains that string
    if (!answersArr.includes(inputID) && answersArr.length < 3) {
        answersArr.push(inputID)
        console.log(answersArr)
    }

    console.log('"answersArr" now counts ' + answersArr.length + ' items')
    
}

// Get the modal
var modal = document.getElementById('chatMdlCtn');

//Check orientation of screen
$(window).on("deviceorientation", function( event ) {
    if (window.matchMedia("(orientation: portrait)").matches) {
        orientPortrait = true
    }
    if (window.matchMedia("(orientation: landscape)").matches) {
        orientPortrait = false
    }
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

$(document).ready(function(){

    var inputsArr = null

    for (var i = 0; i<questionsArr.length; i++) {
        $("#chat-window").append('<div class="bot-interaction"><div class="interaction-bloc"><div class="question"><div class="avatar"></div><div class="qtn-bloc"><p>'+ questionsArr[i].labelContent + '</p></div></div><div class="answer"><form id="' + questionsArr[i].formID +'" action="post"></form></div></div></div>');
        inputsArr = questionsArr[i].inputs
        // console.log(inputsArr)
        for (var j = 0; j<inputsArr.length; j++) {
            $('#'+ questionsArr[i].formID).append('<input id="' + inputsArr[j].ID + '" type="button" name="" value="' + inputsArr[j].Value + '" onclick="setParameters()" />')
        }
    }

    $(".bot-interaction").each(function(){
        $(this).addClass("disabled")
        if (!$(this).hasClass("intro") && !$(this).is(".bot-interaction:eq(2)")) {
            $(this).find(".question").append('<button class="backTrack" type="button"><img src="./img/back-triangle.png" /></button>')
        }
    })

    //opens chat to intro button click
    // $("#bootChatBtn").click(function(){

    //     if (width < 992 || orientPortrait) {
    //         $("#main-ctn").addClass("blue-bg")
    //         $("#intro").animate({left:'-100%'}, "slow").hide();
    //         $("#chat-window").fadeIn()
    //     } else {
    //         $("#intro").animate({right:'-100%'}, "slow");
    //         $("#chat-window").animate({right:'0'}, "slow")
    //     }

    //     var passedIntro = false

    //     setTimeout(function(){
    //         enableInteraction(".bot-interaction:first")
    //     },600);

    //     setTimeout(function(){
    //         enableInteraction(".bot-interaction:eq(1)")
    //         passedIntro = true
    //     },1600);

    //     if (passedIntro = true) {
    //         setTimeout(function(){
    //             enableInteraction(".bot-interaction:eq(2)")
    //         },2500)
    //     }
    // });

    var chatInit = function() {
        if (width < 992 || orientPortrait) {
            $("#main-ctn").addClass("blue-bg")
            // $("#intro").animate({left:'-100%'}, "slow").hide();
            $("#chat-window").fadeIn()
        } else {
            // $("#intro").animate({right:'-100%'}, "slow");
            $("#chat-window").animate({right:'0'}, "slow")
        }

        var passedIntro = false

        setTimeout(function(){
            enableInteraction(".bot-interaction:first")
        },600);

        setTimeout(function(){
            enableInteraction(".bot-interaction:eq(1)")
            passedIntro = true
        },1600);

        if (passedIntro = true) {
            setTimeout(function(){
                enableInteraction(".bot-interaction:eq(2)")
            },2500)
        }
    }

    chatInit()

    //closes the modal
    // $(".closeModal").click(function(){
    //     $("#chatMdlCtn").fadeOut()
    // })

    $("#1A, #1B, #1C").click(function(){
        enableInteraction(".bot-interaction:eq(3)")
    });

    $("#2A, #2B").click(function(){
        enableInteraction(".bot-interaction:eq(4)")
    });

    $("#3A, #3B, #3C").click(function(){
        // $("#chatMdlCtn").find(".modal-content").addClass("extended");
        $(this).parents(".interaction-bloc").css("margin-bottom","120px")
        $("#send-param-div").fadeIn("slow");
        $('#chat-window').animate({
            scrollTop: $("#send-param-div").offset().top
        },600);
        setTimeout(function(){
            $('#send-param-div').animate({height: '100%',},400);
            $('#send-param-div div').toggleClass("visible")
            $('#send-param-div').find("#reduce-Cmd-Btn img").fadeIn("slow")
        },400)
    });

    function enableInteraction(element) {
        $(element).removeClass("disabled")
        toggleLastClass();
        if ($(element).find(".backTrack").length > 0) {
            $(".backTrack").show()
        }
        $(element).fadeIn();
        $('#chat-window').animate({
            scrollTop: $(element).offset().top
        },600);
    }

    function toggleLastClass() {
        $(".bot-interaction").each(function(){
            if ($(this).hasClass("last")) {
                $(this).removeClass('last')
            }
        });
    
        $('.bot-interaction:not(".disabled"):last').addClass('last');
        $('.bot-interaction:not(".last")').addClass('disabled')
    }

    $(document).on ("click", ".backTrack", function (){

        var bloc = $(this).parents('.bot-interaction');
        console.log('"bloc"\'s index equals ' + $(bloc).index() )

        console.log(answersArr);
        answersArr.pop();
        console.log('"paramArr" now counts ' + answersArr.length + ' items')
        console.log(answersArr);

        if (bloc.hasClass("last")) {

            $(bloc).removeClass("last");
            $(bloc).addClass("disabled");
            $(bloc).prev().removeClass("disabled");

            var radio = bloc.find('input');

            radio.each(function() {
                if ($(this).attr("disabled")) {
                    $(this).removeAttr("disabled")
                }

                if ($(this).hasClass("selected")) {
                    $(this).removeClass("selected")
                }
            });

            $('.bot-interaction:not(".disabled"):last').addClass('last');

            if ($(bloc).index() > 1) {
                $(bloc).fadeOut()
                var radioPrev = bloc.prev().find('input')
                radioPrev.each(function() {
                    if ($(this).attr("disabled")) {
                        $(this).removeAttr("disabled")
                    }
    
                    if ($(this).hasClass("selected")) {
                        $(this).removeClass("selected")
                    }
                });
            }
        }

        if ($("#send-param-div").is(":visible")) {
            $("#send-param-div").hide()
        }
    });

    $(document).on ("click", "#reduce-Cmd-Btn", function (){
        if ($(this).hasClass("to-expand")) {
            $('#send-param-div').animate({height: '100%',},400);
            $("#chat-window").css("overflow-y","hidden");
            $(this).css("margin-top","20%")
        } else {
            $('#send-param-div').animate({height: '60px',},400);
            $("#chat-window").css("overflow-y","scroll");
            $(this).css("margin-top","10px")
        }
        // $('#send-param-div').animate({height: '60px',},400);
        $(this).toggleClass("to-expand");
        $('#send-param-div div').toggleClass("visible")
    });

    $(document).on ("click", "#sendParamBtn", function () {
        // $(this).val(answersArr)

        $('#ParamArray').val(JSON.stringify(answersArr))
        
        // $.post( $("#devSubmit").attr("action"),
            
        //     //$("#myForm :input").serializeArray(), 
        //     function(info){ $("#result").html(info); 
        // });

        // $("#devSubmit").submit( function() {
        //     return false;	
        // });
    });
});