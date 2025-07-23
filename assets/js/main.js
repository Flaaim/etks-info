$(document).ready(function(){
    function shouldShowPopup(){
        const popupData = localStorage.getItem('popupData');
        if(!popupData){
            return true;
        }
        try{
            const data = JSON.parse(popupData);
            const twoDays = 2 * 24 * 60 * 60 * 1000;
            const now = new Date().getTime();
            const diff = now - data.lastShown;
            return (diff) > twoDays;
        }catch{
            return true;
        }
    }

    function setPopupShown(){
        const popupData = JSON.stringify({lastShown:new Date().getTime()})
        localStorage.setItem('popupData', popupData);
    }

    if(shouldShowPopup()){
        $.magnificPopup.open({
            items: {
                src: '#small-dialog',
                type: 'inline'
            }
        })
        setPopupShown();
    }

})


