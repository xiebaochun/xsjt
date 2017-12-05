


$(window).scroll(function(){

    // console.log($(window).scrollTop())
    
    if($(window).scrollTop() > 1){
        $('.banner').css({transition:'all 0.5s',marginTop: 0});
    }else{        
        $('.banner').css({transition:'all 0.5s',marginTop: '85px'});
    }

    if($(window).scrollTop() >= 270 ){
        // console.log($(document).width());
        $('.nav-slide').css({transition:'all 0.5s', position: 'fixed' , top: '86px' , left:'auto'});
        if($(document).width() <= 1203){
            $('.nav-slide').css({transition:'all 0.5s', position: 'fixed' , top: '86px' , left: 0});
        }
    }else{        
        $('.nav-slide').css({transition:'all 0.5s', position:'static'});
    }

});


var navList = document.querySelectorAll('.nav-item ul li');

for(var i=0;i<navList.length;i++){
    navList[i].onclick = function(){
        for(var j =0;j<navList.length;j++){
            navList[j].children[0].style.color = '#fff';
        };        
        this.children[0].style.color = '#eb7016';
    };
}



// 左侧边栏点击增加样式

// $('.nav-slide ul li').click(function(){
//     $(this).addClass('active');
//     $(this).siblings().removeClass('active');
// })



// 返回顶部
function back (){
    
    // console.log($(document).height());

    if($(document).height() > 948){
        $('.top').css({display:'block'})
    }
    $('.top').click(function(){
        $(window).scrollTop(0);
    })
}
back();
