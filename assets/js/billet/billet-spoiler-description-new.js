            /*spoiler-billet-for-billet-footer */

document.addEventListener( 'DOMContentLoaded', function ()
{
    const compilations = document.getElementsByClassName( 'legal-compilation' );
    let spoilerBtn = compilations.querySelectorAll('.legal-play');
    spoilerBtn.forEach(i => {   
        i.addEventListener('click', (event) => {
            if(!event.target) return;  
            event.target.closest('.legal-play').classList.toggle('legal-active');

            let parentBlock = event.target.closest('.billet-item'); 
                if (!parentBlock) { 
                    return;
                };

            let spoilerContent = parentBlock.querySelector('.billet-footer'); 
            spoilerContent.classList.toggle('legal-active');

        });
    })


} );