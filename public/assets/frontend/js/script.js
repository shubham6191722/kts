// const range = document.querySelectorAll(".range-slider span input");

// progress = document.querySelector(".range-slider .progress");

// let gap = 1000;

// const inputValue = document.querySelectorAll(".numberVal input");

// range.forEach((input) => {

//   input.addEventListener("input", (e) => {
//     let minRange = parseInt(range[0].value);
//     let maxRange = parseInt(range[1].value);

//     if (maxRange - minRange < gap) {
//       if (e.target.className === "range-min") {
//         range[0].value = maxRange - gap;
//       } else {
//         range[1].value = minRange + gap;
//       }
//     } else {
//       progress.style.left = (minRange / range[0].max) * 100 + "%";
//       progress.style.right = 100 - (maxRange / range[1].max) * 100 + "%";
//       inputValue[0].value = minRange;
//       inputValue[1].value = maxRange;
//     }
//   });

// });

// var min_price = $('.min-value input').val();
// var max_price = $('.max-value input').val();

// if(max_price){
//     progress.style.left = ((min_price / range[0].max) * 100) + "%";
//     progress.style.right = 100 - (max_price / range[1].max) * 100 + "%";
// }


// $("#min_price,#max_price").on('change', function () {

//   var minRange = parseInt($("#min_price").val());

//   var maxRange = parseInt($("#max_price").val());

//   progress.style.left = (minRange / range[0].max) * 100 + "%";
//   progress.style.right = 100 - (maxRange / range[1].max) * 100 + "%";

//   $("#min_price_slider").val(minRange);		
//   $("#max_price_slider").val(maxRange);

// });



var rangeInput = document.querySelectorAll(".range-input input"),
priceInput = document.querySelectorAll(".price-input input"),
range = document.querySelector(".slider-amount .progress");
var priceGap = 10;

priceInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);

        if((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max){
            if(e.target.className === "input-min"){
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
            }else{
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});

rangeInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

        if((maxVal - minVal) < priceGap){
            if(e.target.className === "range-min"){
                rangeInput[0].value = maxVal - priceGap
            }else{
                rangeInput[1].value = minVal + priceGap;
            }
        }else{
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

            $("#min_price").val(minVal);
            $("#max_price").val(maxVal);
        }
    });
});


var min_price = $('.price-input .input-min').val();
var max_price = $('.price-input .input-max').val();

if(max_price){
    range.style.left = ((min_price / rangeInput[0].max) * 100) + "%";
    range.style.right = 100 - (max_price / rangeInput[1].max) * 100 + "%";
}