let quiz_app=document.querySelector(".quiz-app");
let questions_count =document.querySelector(".questions-count span");
let question_area=document.querySelector(".question-area");
let answers_area=document.querySelector(".answers-area");
let submit_button=document.querySelector(".submit-button");
let spans_container=document.querySelector(".spans");
let result_container=document.querySelector(".result");

let I=0;
let index=0;
let rightAnswers=0;
let chosen_answers_array=[];


function getQuestions() {
    let myRequest = new XMLHttpRequest();
    myRequest.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        // console.log(this.responseText);
        let quiz_array = JSON.parse(this.responseText);
        console.log(quiz_array);
        let questions_array=quiz_array;//.sort((a, b) => 0.5 - Math.random())
        let array_length=questions_array.length;
        // console.log(array_length);
        questions_count.innerHTML=array_length;//show the questions count in the html file

        for (let i = 0; i < array_length/4; i++) {
            let span = document.createElement("span");
            span.innerHTML=i+1;
            if(i==0){
                span.className="on";
            }
            spans_container.appendChild(span);
         }
        

         addQuestionData(questions_array);
        
         //onclick method
         submit_button.onclick = () => {
            getChosenAnswer();
        
            index++;

            if(index<array_length/4){
                //empty the previous question area and the answers area
                question_area.innerHTML="";
                answers_area.innerHTML="";
                //fill the question area and the answers area
                addQuestionData(questions_array);

                //paint the span
                paintSpan();

            }else if(index==array_length/4){
                showResult(array_length);
            }
            
         }     

    }
}
    myRequest.open("GET","databaseConnection.php", true);
    myRequest.send();
}
 getQuestions();

//  $.get("databaseConnection.php",{data_array:true},function(data){console.log(JSON.parse(data))})
//  $.get("databaseConnection.php",{right_answers_array:true},function(data){console.log(JSON.parse(data))})

function addQuestionData(array) {
    // the question

    let question = document.createElement("h2");
    // Create Question Text
    let question_text = document.createTextNode(array[I].question);
    question.appendChild(question_text);
    // Append The H2 To The question area
    question_area.appendChild(question);

    // the answers

    for (let i=I; i <4+I; i++) {

        // Create parent div
        let parent_div = document.createElement("div");
        // Add class
        parent_div.className = 'answer';

        // Create Radio Input
        let radio_input = document.createElement("input");
        radio_input.name = 'answer_radio';
        radio_input.type = 'radio';
        radio_input.id = `answer_${i+1}`;
        radio_input.dataset.answer=array[i][`answer`];
        if(i==I){
            radio_input.checked=true;
        }

        //ceate the label
        let label=document.createElement("label");
        label.htmlFor = `answer_${i+1}`;// add the attribute for
        // Create Label Text
        let label_text = document.createTextNode(array[i][`answer`]);
        label.appendChild(label_text);

        // append Input + Label To the parent div
        parent_div.appendChild(radio_input);
        parent_div.appendChild(label);

        // Append the parent div to the answers area
        answers_area.appendChild(parent_div);
    }
    
    I=I+4;
}

function getChosenAnswer () {
    let answers = document.getElementsByName("answer_radio");
    let chosen_answer;
    for (let i = 0; i < 4; i++) {
    if (answers[i].checked) {
    chosen_answer = answers[i].dataset.answer;
    chosen_answers_array.push(chosen_answer);
    console.log(chosen_answers_array);
    }
    }
    // if (right_answer === chosen_answer) {
    // rightAnswers++;
    // console.log("Good Answer");
    // }else{
    //     chosen_answers_array.push(chosen_answer);
    //     right_answers_array.push(right_answer);
    // }
}

function paintSpan(){
    let spans = document.querySelectorAll(".spans span");
    spans[index].className="on";
}

function showResult(array_length){
    question_area.remove();
    answers_area.remove();
    submit_button.remove();
    spans_container.remove();
    $.get("databaseConnection.php",{right_answers_array:true},function(data){
            let right_answers_array=JSON.parse(data);
            for (let i = 0; i < array_length/4; i++) {
                if(chosen_answers_array[i]=right_answers_array[i].answer){
                    rightAnswers++;
                    console.log(5555);
                }
            }
          }
        )
    // if(rightAnswers>array_length*(70/100)){
    //     result_container.innerHTML=`<span class='on bold'>Perfect</span> you answered ${rightAnswers} from ${array_length}.`;
    // }else if(rightAnswers<=array_length*(7/10)&&rightAnswers>=array_length*(1/2)){
    //     result_container.innerHTML=`<span class='good bold'>Good</span> you answered ${rightAnswers} from ${array_length}.`;
    // }else{
    //     result_container.innerHTML=`<span class='not-good bold'>Not Good</span> you answered just ${rightAnswers} from ${array_length}.`;
    // }
    // if(chosen_answers_array.length>0){
    //     quiz_app.innerHTML+="<span class=bold>The Correction:</span><br>";
    //     for (let i = 0; i < chosen_answers_array.length; i++) {
    //         quiz_app.innerHTML+=`<span class=not-good>the chosen answer is:</span> ${chosen_answers_array[i]} <br> <span class=dark-green>the right answer is:</span> ${right_answers_array[i]}<br><br>`;   
    //     }
    // }
}


 
