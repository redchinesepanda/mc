
// review-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // function prepareItem( element )
	// {
    //     element.classList.add( 'legal-cut-item' );
    // }

    function prepareItems( element )
	{
        if ( element.children.length > 6 )
        {
            // [ ...element.children ].slice( 6 ).forEach( prepareItem );
            // console.log( 'element.children.length : ' + element.children.length );
        }
        
		// element.dataset.cutSetId = setID;
		
		// if ( element.classList.contains( 'legal-cut-control' ) )
		// {
		// 	element.addEventListener( 'click', toggleDataset, false );

		// 	setID++;
		// }
	}

    let setID = 0;

    document.querySelectorAll(
		'.legal-menu .sub-menu'
	)
	.forEach( prepareItems );
} );

// review-cut-js end

// document.addEventListener( 'DOMContentLoaded', function ()
// {
//     /*--------------------spoiler-for-menu-3-level--------------*/
//     let spoilerBtn = document.querySelectorAll('.link-hidden-list-3-level');
//     spoilerBtn.forEach(i => {   
//         i.addEventListener('click', (event) => {
//             if(!event.target) return;  
//             event.target.closest('.link-hidden-list-3-level').classList.toggle('rotate-svg').innerText = '"Hide all';

//             let parentBlock = event.target.closest('.sub-menu'); 
//                 if (!parentBlock) { 
//                     return;
//                 };
//             let popup = parentBlock.querySelector('.content-hidden-list-3-level'); 
//             if(popup.classList.contains('is_open')) { 
//                 popup.classList.remove('is_open'); 
//                 popup.style.display = 'none';  
//             } else {
//                 popup.classList.add('is_open');  
//                 popup.style.display = 'flex'; 
//             }

//             let parentBlock1 = event.target.closest('.link-hidden-list-3-level'); 
//                 if (!parentBlock1) { 
//                     return;
//                 };
//             let linkSpoiler = parentBlock1.querySelector('.item-title');
//             console.log( linkSpoiler );
//             if(linkSpoiler.dataset.trigger == 'false') { 
//                 linkSpoiler.textContent = "Show all"; 
//                 linkSpoiler.dataset.trigger = true;  
//             } else {
//                 linkSpoiler.textContent = "Hide";
//                 linkSpoiler.dataset.trigger = false;
//             }

//         });
//     })

// } );