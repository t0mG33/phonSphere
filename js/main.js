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

//Create an array to store each answer.
var answersArr = [];

//Host device objects returned by server
var responseArr = [];

//Responsive design
var width = $(window).width();
var orientPortrait = null

function setParameters(event) {

    $(event.target).addClass("selected");

    var inputID = event.target.id;

    // if (inputID === '1A' || inputID === '1B' || inputID === '1C') {
    //     loopThroughFormInputs('answerForm1')
    // } else if (inputID === '2A' || inputID === '2B') {
    //     loopThroughFormInputs('answerForm2')
    // } else if (inputID === '3A' || inputID === '3B' || inputID === '3C') {
    //     loopThroughFormInputs('answerForm3')
    // }

    // function loopThroughFormInputs(formId) {
    //     var form = document.getElementById(formId);
    //     var radio = form.getElementsByTagName('input')
    //     for (var i=0; i<radio.length; i++) {
    //         radio[i].disabled = true
    //     }
    // }

    //Push parameter value into the answersArr unless array already contains that string
    if (!answersArr.includes(inputID) && answersArr.length < 3) {
        answersArr.push(inputID)
        console.log(answersArr)
    }

    console.log('"answersArr" now counts ' + answersArr.length + ' items')
    
}

// Redering the input elements inside each card as per the content of questionsArr
function renderUserInputForm(arr) {
    var count = 1;

    $(questionsArr).each(function(i, q){

        // var buttonType = function() {
        //     if (i === ($(questionsArr).length - 1)) {
        //         return "submit"
        //     } else {
        //         return "button"
        //     }
        // }

        $("#userInputForm").append('<div id="interaction' + count + '" class="d-none card interaction w-100 h-auto p-3 mx-5 start-0 txt-ctt"><div class="card-body"><h1 class="card-question mb-5 text-center fs-1 fw-bold">' + q.labelContent + '</h1></div></div>');
        arr = q.inputs;
        $(arr).each(function(n, input) {
            $('#interaction'+ count).find(".card-body").append('<div class="input-group d-block"><input id="' + input.ID + '" type="radio" name="" value="' + input.Value + '" class="mt-2" /><label for="' + input.ID + '" class="fs-4 ms-2">' + input.Value + '</label></div>')
        });
        $('#interaction'+ count).find(".card-body").append('<button type="button" id="submit' + q.formID + '" class="d-block mx-auto mt-4 py-2 px-3 rounded-pill fs-6 fw-bold animate__animated animate__pulse">Submit</button>');
        count++;
    })
}

//Sliding animation for each card in the input form
function cardSlide(cardId, event) {
    $(event.target).parents(".card").addClass("animate__animated animate__backOutLeft");
    $("#" + cardId).removeClass("d-none").addClass("is-active animate__animated animate__backInRight");
    $(event.target).parents(".card").addClass("d-none");
}

$(document).ready(function(){

    var inputsArr = null;

    //Creating form element in the UI and rendering the input form
    $(".jumbo").append('<form id="userInputForm" class="d-none" method="POST" action="devices.php" ></form>');
    renderUserInputForm(inputsArr)

    $("#start-btn").on("click", function(event) {
        $(event.target).parents(".card").addClass("d-none");
        $("#userInputForm").removeClass("d-none");
        cardSlide("interaction1", event);
    });

    $("#submitanswerForm1").on("click", function(event) {
        cardSlide("interaction2", event);
    });

    $("#submitanswerForm2").on("click", function(event) {
        cardSlide("interaction3", event);
    });

    $("#submitanswerForm3").on("click", function(event) {
        $("#userInputForm").append('<div id="interaction4" class="card interaction w-100 h-auto p-3 mx-5 start-0 txt-ctt"><div class="card-body"><h1 class="card-question mb-5 text-center fs-1 fw-bold">Excellent!</h1><p>We got all the information we need to fetch the perfect smartphone for you!</p><p>Ready?!</p><input type="hidden" id="ParamArray" name="ParamArray" value=""><input type="submit" id="sendParamBtn" name="sendParam" value="Let\'s do it!" /></div></div>');
        cardSlide("interaction4", event);
    });

    $(document).on ("click", "#sendParamBtn", function () {
        $('#ParamArray').val(JSON.stringify(answersArr))
    });

    // $("#submitanswerForm3").submit(function(event) {
    //     /* Stop form from submitting normally */
    //     event.preventDefault();

    //     var FoO = $(answersArr).serialize();

    //     $.ajax({
    //         type : "POST",  //type of method
    //         url  : "devices.php",  //your page
    //         data : FoO,// passing the values
    //         // contentType: "application/json; charset=utf-8",
    //         dataType: "json",
    //         success: function(res){  
    //             //do what you want here...
    //             console.log(JSON.stringify(res));
    //         },
    //         error: (error) => {
    //             console.log(JSON.stringify(error));
    //         }
    //     });
    // });

    $("input").on("click", function(event) {
        setParameters(event)
    });
});