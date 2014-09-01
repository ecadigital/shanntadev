(function( $ ){

	window.SVGAnimations = function(){
			
		/*----------------------------------------------------------------------------
		 Init process
		----------------------------------------------------------------------------*/
		var init = function (){
			// Use Modernizr to check if SVG is available
			if (Modernizr.svg) {
				loadIllustrations();
				if (Modernizr.touch) {
					startAnimationsMobile();
				} else {
					startAnimations();					
				}
			}
		};
		
		/*----------------------------------------------------------------------------
		* Object to store all the Snap canvas objects, one for each single animation
		* TODO: I added this trying to solve a problem with iOS (see comment in 
		* animateGrowingTrees(), but eventually it seems this is not necessary...
		----------------------------------------------------------------------------*/
		var allCanvas = {};
		
		
		/*----------------------------------------------------------------------------
		* Load SVG illustrations
		* For each <img> of class .animation-container, takes the image and animation
		* names from attributes in the markup (set in backend). Then replaces the
		* <img> by a <div>, and loads the SVG illustration into this <div>
		* This is done because the markup contains actually <img> to allow both
		* SVG or a normal image (necessary for IE8)
		----------------------------------------------------------------------------*/
		var loadIllustrations = function () {
			// Grab all elements with class .animation-container
			$('.animation-container').each( function () {
				
				// Take out the image source, image name and animation name
				var imageSource = $(this).find('img').attr('src'),
					imageName = imageSource.split(/[// ]+/).pop().split('.')[0],
					animation = $(this).find('img').attr('data-svg-animation');
					
				// Create a empty <div> to be used as container for the SVG, and replace the <img> with it
				// Use image name, image source and animation name in attributes to be used later
				var container = $('<div class="svg-container ' + imageName + '" data-svg-animation="' + animation + '" src="' + imageSource + '"></div>');
				$(this).find('img').replaceWith(container);

				// Load the image into the created container
				var canvas = Snap('div.svg-container.' + imageName);
				allCanvas[imageName] = canvas;
				
				Snap.load(imageSource, function (fragment) {
					allCanvas[imageName].append(fragment);
					// Call function to set padding (see below)
					setPaddingBottom(imageName);
				});
			});
		};
		
		
		/*----------------------------------------------------------------------------
		* Set the CSS property padding-bottom
		* We calculate the percentage value of padding-bottom we need to set, as the 
		* relation between height and width. we use the approach in this website 
		* http://demosthenes.info/blog/744/Make-SVG-Responsive to make SVG responsive
		* so we need to give the SVG container <div> a 100% padding-bottom for the
		* illustration to be displayed. The problem is that with 100%, all images are
		* squared, and if the image is "very rectangular" (e.g. 2:1), ther'll be much
		* space under the illustration.
		* So we calculate the proportionality between the height and width of the
		* actual SVG animation using BoundaryBox.
		* We add 10% to give it some extra space.
		----------------------------------------------------------------------------*/
		var setPaddingBottom = function (imageName) {
			var canvas = allCanvas[imageName];
			var height = canvas.select('g').getBBox().height;
			var width = canvas.select('g').getBBox().width;
			var padding = height * 100 / width;
			padding = padding + 10;
			$('div.svg-container.' + imageName).css('padding-bottom', padding + '%');
		};
		
		
		/*----------------------------------------------------------------------------
		* Start SVG animations for desktop and laptop
		* Start the animations using jQuery Waypoints library. Animations will fire
		* only when scrolling down and with 60% offset
		----------------------------------------------------------------------------*/
		var startAnimations = function() {			
			$('.animation-container').waypoint(function (direction) {
				if (direction === 'down') {
					fireAnimation($(this));
				}	
			}, {
				offset : '60%'
			});
		};
		
		
		/*----------------------------------------------------------------------------
		* Start SVG animations for mobile devices
		* Start the animations using 'touchend' event instead of with waypoints,
		* because waypoints library doesn't work really well on touch devices.
		* TODO: this approach is not perfect either! When touch and scroll it may
		* get stuck quite easily...
		----------------------------------------------------------------------------*/
		var startAnimationsMobile = function() {			
			$('.animation-container').on({ 'touchend' : function() { 
				fireAnimation($(this));
			}});
		};
		
		
		/*----------------------------------------------------------------------------
		* Fire SVG animations
		* Fires the SVG in a given element. Just grabs the image name, image source
		* and animation name, and selects which animation function to use.
		----------------------------------------------------------------------------*/
		var fireAnimation = function (animationContainer) {
			var imageSource = animationContainer.find('div.svg-container').attr('src'),
				imageName = imageSource.split(/[// ]+/).pop().split('.')[0],
				animation = animationContainer.find('div.svg-container').attr('data-svg-animation');

			// Decide which animation to start depending on animation name
			switch (animation) {
				case 'pencil-pad': 
					animatePencilPad(imageName);
					break;
				case 'growing-trees': 
					animateGrowingTrees(imageName);
					break;
				case 'rabbit': 
					animateRabbit(imageName);
					break;
				case 'handshake': 
					animateHandshake(imageName);
					break;
				case 'factory': 
					animateFactory(imageName);
					break;
				case 'soil-pond': 
					animateSoilPond(imageName);
					break;
			}
		};
		
		
		/*----------------------------------------------------------------------------
		* Determines if a SVG is being animated
		* Given an image name, get the canvas from the allCanvas "list", and then
		* select every single element contained in the canvas and find out whether
		* it is being animated.
		----------------------------------------------------------------------------*/
		var isInAnimation = function (imageName) {
			var inAnimation = false,
				elements = allCanvas[imageName].selectAll('#' + imageName + ' *');
			// Browse every element within the canvas
			for (var i=0; i<elements.length; i++) {
				// Use Snap function .inAnim()
				var currentAnimation = elements[i].inAnim()[0];
				if ( currentAnimation ) {
					// If there is current animation and its status is between 0 and 1,
					// we consider the canvas to be in the middle of an animation
					if ( currentAnimation.status() < 1 ) {
						inAnimation = true;
					}
				}
			}
			return inAnimation;
		};
		
		
		/*----------------------------------------------------------------------------
		* Stops animations in a SVG
		* Given a canvas, (i.e., a Snap object created from a SVG container <div>),
		* we select every single element contained in the canvas and stop any
		* animation that may be in progress.
		* Very similar code to isInAnimation(), see above.
		----------------------------------------------------------------------------*/
		var stopAnimations = function (imageName) {
			var	elements = allCanvas[imageName].selectAll('#' + imageName + ' *');			
			for (var i=0; i<elements.length; i++) {
				var currentAnimation = elements[i].inAnim()[0];					
				if ( currentAnimation ) {
					currentAnimation.stop();
				}
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		Animation: PAD & PENCIL
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/		
		var animatePencilPad = function(imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			// Select elements within the SVG we want to animate
			var pencil = canvas.select('#pencil');
			
			if (!isInAnimation(imageName)) {
				// We move the pencil anti-clockwise and then clockwise, 3 times each using callback functions
				// 'r' is the radius and the other values are the center of rotation
				var pencilAntiClockwise = {transform:'r-30,142,162'},
					pencilClockwise = {transform:'r0,142,162'};

				pencil.animate( pencilAntiClockwise, 300, mina.linear, function () {
					pencil.animate( pencilClockwise, 300, mina.linear, function() {
						pencil.animate( pencilAntiClockwise, 300, mina.linear, function () {
							pencil.animate( pencilClockwise, 300, mina.linear);
						});
					});
				});
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		Animation: GROWING TREES
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/
		var animateGrowingTrees = function(imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			
			/* TODO: we use the image name in all the selectors because otherwise it's not working 
			 * correctly on iOS. It happens with the functions that are called to animate more than 
			 * one SVG (like this and animateFactory(). In these cases, the second (or 3rd) animation
			 * is not working, and instead it is animating the first SVG. So I added the image name
			 * as the ID of the main <g> element within the SVG. This has the problem that the image
			 * name must be exactly that one, so if a user uploads the same image twice to WordPress
			 * and the second one will be automatically appended a '2', it won't work!
			 */		
			
			// Select elements within the SVG we want to animate
			var littleTree = canvas.select('#' + imageName + ' #little-tree');
			var littleTree_trunk = littleTree.select('#' + imageName + ' #trunk line');
			var littleTree_leaves = littleTree.select('#' + imageName + ' #leaves circle');
			var littleTree_branch = littleTree.select('#' + imageName + ' #branch line');
			
			var mediumTree = canvas.select('#' + imageName + ' #medium-tree');
			var mediumTree_trunk = mediumTree.select('#' + imageName + ' #trunk line');
			var mediumTree_leaves = mediumTree.select('#' + imageName + ' #leaves circle');
			var mediumTree_branch = mediumTree.select('#' + imageName + ' #branch line');
			
			var bigTree = canvas.select('#' + imageName + ' #big-tree');
			var bigTree_trunk = bigTree.select('#' + imageName + ' #trunk line');
			var bigTree_leaves = bigTree.select('#' + imageName + ' #leaves circle');
			var bigTree_branch = bigTree.select('#' + imageName + ' #branch line');
			
			var heart = canvas.select('#' + imageName + ' #heart');
			var heart_shape = heart.select('#' + imageName + ' #shape path');
			var heart_shine = heart.select('#' + imageName + ' #shine path');
			
			if (!isInAnimation(imageName)) {
					
				// Grab starting values in order to "hide" elements and then animate them back
				var littleTreeTrunk_y1 = littleTree_trunk.attr('y1');
				var littleTreeTrunk_y2 = littleTree_trunk.attr('y2');				
				var mediumTreeTrunk_y1 = mediumTree_trunk.attr('y1');
				var mediumTreeTrunk_y2 = mediumTree_trunk.attr('y2');				
				var bigTreeTrunk_y1 = bigTree_trunk.attr('y1');
				var bigTreeTrunk_y2 = bigTree_trunk.attr('y2');
				
				var littleTreeLeaves_r = littleTree_leaves.attr('r');
				var mediumTreeLeaves_r = mediumTree_leaves.attr('r');
				var bigTreeLeaves_r = bigTree_leaves.attr('r');
				
				var littleTreeBranch_x1 = littleTree_branch.attr('x1');
				var littleTreeBranch_y1 = littleTree_branch.attr('y1');
				var littleTreeBranch_x2 = littleTree_branch.attr('x2');
				var littleTreeBranch_y2 = littleTree_branch.attr('y2');
				var mediumTreeBranch_x1 = mediumTree_branch.attr('x1');
				var mediumTreeBranch_y1 = mediumTree_branch.attr('y1');
				var mediumTreeBranch_x2 = mediumTree_branch.attr('x2');
				var mediumTreeBranch_y2 = mediumTree_branch.attr('y2');
				var bigTreeBranch_x1 = bigTree_branch.attr('x1');
				var bigTreeBranch_y1 = bigTree_branch.attr('y1');
				var bigTreeBranch_x2 = bigTree_branch.attr('x2');
				var bigTreeBranch_y2 = bigTree_branch.attr('y2');
				
				var heartShape_path = heart_shape.attr('d');
				var heartShape_centerX = parseFloat(heartShape_path.split(',')[0].substring(1));
				var heartShape_centerY = parseFloat(heartShape_path.split(',')[1].split(/c|C/)[0]) / 2;
				var heartShine_path = heart_shine.attr('d');
				
				
				// Reset position of every element
				littleTree_trunk.attr({y2:littleTreeTrunk_y1});
				mediumTree_trunk.attr({y2:mediumTreeTrunk_y1});
				bigTree_trunk.attr({y2:bigTreeTrunk_y1});

				littleTree_leaves.attr({r: 0});
				mediumTree_leaves.attr({r: 0});
				bigTree_leaves.attr({r: 0});
				
				littleTree_branch.attr({x2:littleTreeBranch_x1, y2:littleTreeBranch_y1});
				mediumTree_branch.attr({x2:mediumTreeBranch_x1, y2:mediumTreeBranch_y1});
				bigTree_branch.attr({x2:bigTreeBranch_x1, y2:bigTreeBranch_y1});
				
				heart_shape.attr({d:'M' + heartShape_centerX + ',' + heartShape_centerY});
				heart_shine.attr({d:'M' + heartShape_centerX + ',' + heartShape_centerY});	
			
				
				// Start animations
				littleTree_trunk.animate({y2:littleTreeTrunk_y2}, 500, mina.easeout);
				mediumTree_trunk.animate({y2:mediumTreeTrunk_y2}, 500, mina.easeout);
				bigTree_trunk.animate({y2:bigTreeTrunk_y2}, 500, mina.easeout);

				setTimeout(function() {
					littleTree_leaves.animate({r:littleTreeLeaves_r}, 700, mina.easein);
					mediumTree_leaves.animate({r:mediumTreeLeaves_r}, 700, mina.easein);
					bigTree_leaves.animate({r:bigTreeLeaves_r}, 700, mina.easein);
				}, 500);

				setTimeout(function() {
					littleTree_branch.animate({x2:littleTreeBranch_x2, y2:littleTreeBranch_y2}, 300, mina.easeout);
					mediumTree_branch.animate({x2:mediumTreeBranch_x2, y2:mediumTreeBranch_y2}, 300, mina.easeout);
					bigTree_branch.animate({x2:bigTreeBranch_x2, y2:bigTreeBranch_y2}, 300, mina.easeout);
				}, 700);

				setTimeout(function() {
					heart_shape.animate({d:heartShape_path}, 500, mina.bounce);
					heart_shine.animate({d:heartShine_path}, 500, mina.bounce);
				}, 1200);
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		Animation: RABBIT
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/
		var animateRabbit = function(imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			// Select elements within the SVG we want to animate
			var flower = canvas.select('#flower');
			var butterfly = canvas.select('#butterfly');
			var rabbit = canvas.select('#rabbit');
			
			if (!isInAnimation(imageName)) {
				
				// Fake animation! It doesn't move anything. I need it to avoid animations getting stuck
				// ToDo: Investigate why I need this. It seems it happens only when we have many animation chains
				// starting at the same time (like here, butterfly and rabbit starting at the same time)
				flower.select('#flowerhead').animate({transform: 'r0,69,136'}, 2000, mina.easeinout);
				
				// Animate butterfly
				butterfly.animate({transform: 't-18,20 r-45,120,65'}, 450, mina.easeinout, function () {
					butterfly.animate({transform: 't-12,-8 r30,120,65'}, 450, mina.easeinout, function () {
						butterfly.animate({transform: 't-10,0 r0,120,65'}, 450, mina.easeinout);
					});
				});

				// Animate rabbit head
				rabbit.select('#rabbit-whole-head').animate({transform: 'r10,200,150'}, 400, mina.easeinout, function () {
					rabbit.select('#rabbit-whole-head').animate({transform: 'r0,200,150'}, 400, mina.easein, function () {
						// Animate rabbit nose
						rabbit.select('#nose').animate({transform: 't1,2'}, 180, mina.easeout, function () {
							rabbit.select('#nose').animate({transform: 't0,0'}, 180, mina.easeout, function () {
								rabbit.select('#nose').animate({transform: 't1,2'}, 180, mina.easeout, function () {
									rabbit.select('#nose').animate({transform: 't0,0'}, 180, mina.easeout, function () {
										rabbit.select('#nose').animate({transform: 't1,2'}, 180, mina.easeout, function () {
											rabbit.select('#nose').animate({transform: 't0,0'}, 180, mina.easeout);
										});
									});
								});
							});
						});
					});
				});
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		Animation: HANDSHAKE
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/		
		var animateHandshake = function (imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			// Select elements within the SVG we want to animate
			var claspedHands = canvas.select('#clasped');
			var farmerHand = canvas.select('#farmer-open');
			var farmerThumb = canvas.select('#farmer-thumb');
			var bussinessmanHand = canvas.select('#businessman');
			
			if (!isInAnimation(imageName)) {
				
				// Hide clasped hands and display open hands
				claspedHands.attr({display:'none'});
				farmerHand.attr({display:'block'});
				farmerThumb.attr({display:'block'});
				bussinessmanHand.attr({display:'block'});

				// Move hands to starting position (separated)
				farmerHand.transform('t320,0');
				farmerThumb.transform('t320,0');
				bussinessmanHand.transform('t-280 ,0');
				
				// Animate hands back to the middle
				farmerHand.animate({transform: 't0,0'}, 800, mina.easeout);
				farmerThumb.animate({transform: 't0,0'}, 800, mina.easeout);
				bussinessmanHand.animate({transform: 't0,0'}, 800, mina.easeout);

				// Hide open hands and display clasped hands
				setTimeout(function () {		
					farmerHand.attr({display: 'none'});
					farmerThumb.attr({display: 'none'});
					bussinessmanHand.attr({display: 'none'});
					claspedHands.attr({display: 'block'});

					// Animate clasped hands up and down
					claspedHands.animate({transform: 't0,10'}, 125, mina.easeout, function () {
						claspedHands.animate({transform: 't0,0'}, 125, mina.easeout, function () {
							claspedHands.animate({transform: 't0,10'}, 125, mina.easeout, function () {
								claspedHands.animate({transform: 't0,0'}, 125, mina.easeout);
							});
						});
					});
				}, 800);
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		Animation: FACTORY
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/		
		var animateFactory = function(imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			// Select elements within the SVG we want to animate
			var smoke_1 = canvas.select('#' + imageName + ' #smoke_1');
			var smoke_2 = canvas.select('#' + imageName + ' #smoke_2');
			var co2_1 = canvas.select('#' + imageName + ' #co2_1');
			var co2_2 = canvas.select('#' + imageName + ' #co2_2');
			var co2_3 = canvas.select('#' + imageName + ' #co2_3');
			
			if (!isInAnimation(imageName)) {

				// Grab starting variables' values
				var smoke_1_x1 = smoke_1.attr('x1');
				var smoke_1_y1 = smoke_1.attr('y1');
				var smoke_1_x2 = smoke_1.attr('x2');
				var smoke_1_y2 = smoke_1.attr('y2');

				var smoke_2_x1 = smoke_2.attr('x1');
				var smoke_2_y1 = smoke_2.attr('y1');
				var smoke_2_x2 = smoke_2.attr('x2');
				var smoke_2_y2 = smoke_2.attr('y2');

				var co2_1_x1 = co2_1.attr('x1');
				var co2_1_y1 = co2_1.attr('y1');
				var co2_1_x2 = co2_1.attr('x2');
				var co2_1_y2 = co2_1.attr('y2');

				var co2_2_x1 = co2_2.attr('x1');
				var co2_2_y1 = co2_2.attr('y1');
				var co2_2_x2 = co2_2.attr('x2');
				var co2_2_y2 = co2_2.attr('y2');

				var co2_3_x1 = co2_3.attr('x1');
				var co2_3_y1 = co2_3.attr('y1');
				var co2_3_x2 = co2_3.attr('x2');
				var co2_3_y2 = co2_3.attr('y2');


				// Reset positions
				smoke_1.attr({x2:smoke_1_x1, y2:smoke_1_y1});
				smoke_2.attr({x2:smoke_2_x1, y2:smoke_2_y1});

				co2_1.attr({x1:co2_1_x2, y1:co2_1_y2, display:'none'});
				co2_2.attr({x1:co2_2_x2, y1:co2_2_y2, display:'none'});
				co2_3.attr({x1:co2_3_x2, y1:co2_3_y2, display:'none'});

				// Animate smoke
				smoke_1.animate({x2:smoke_1_x2, y2:smoke_1_y2}, 600, mina.linear);
				smoke_2.animate({x2:smoke_2_x2, y2:smoke_2_y2}, 600, mina.linear);
				smoke_1.animate({strokeDashoffset:-150}, 2400, mina.linear);
				smoke_2.animate({strokeDashoffset:-150}, 2400, mina.linear);

				// Animate CO2
				setTimeout(function() {
					co2_1.attr({display:'block'});
					co2_2.attr({display:'block'});
					co2_3.attr({display:'block'});
					co2_1.animate({x1:co2_1_x1, y1:co2_1_y1}, 600, mina.linear);
					co2_2.animate({x1:co2_2_x1, y1:co2_2_y1}, 600, mina.linear);
					co2_3.animate({x1:co2_3_x1, y1:co2_3_y1}, 600, mina.linear, function () {
						co2_1.animate({strokeDashoffset:60}, 1200, mina.linear);
						co2_2.animate({strokeDashoffset:60}, 1200, mina.linear);
						co2_3.animate({strokeDashoffset:60}, 1200, mina.linear);
					});		
				}, 600);
			}
		};
		
		
		
		/*~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
		~-~		SOIL POND
		~-~-~-~-~-~~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-*/		
		var animateSoilPond = function(imageName) {
			// Create the canvas to display the SVG using the <div> element we created before
			var canvas = allCanvas[imageName];
			// Select elements within the SVG we want to animate
			var wave = canvas.select('#wave1');
			var weedsE = canvas.select('#weeds1 path#e');
			var weedsF = canvas.select('#weeds1 path#f');
			var weedsG = canvas.select('#weeds1 path#g');
			var bubble1 = canvas.select('g#bubbles circle#air1');
			var bubble2 = canvas.select('g#bubbles circle#air2');
			
			if (!isInAnimation(imageName)) {
				
				// Grab starting variables' values
				var wave_path1 = canvas.select('#wave1').attr('d');
				var wave_path2 = canvas.select('#wave2').attr('d');
				var wave_path3 = canvas.select('#wave3').attr('d');
				var wave_path4 = canvas.select('#wave4').attr('d');

				var weedsE_path1 = canvas.select('#weeds1 path#e').attr('d');
				var weedsE_path2 = canvas.select('#weeds2 path#e').attr('d');
				var weedsE_path3 = canvas.select('#weeds3 path#e').attr('d');
				var weedsF_path1 = canvas.select('#weeds1 path#f').attr('d');
				var weedsF_path2 = canvas.select('#weeds2 path#f').attr('d');
				var weedsF_path3 = canvas.select('#weeds3 path#f').attr('d');
				var weedsG_path1 = canvas.select('#weeds1 path#g').attr('d');
				var weedsG_path2 = canvas.select('#weeds2 path#g').attr('d');
				var weedsG_path3 = canvas.select('#weeds3 path#g').attr('d');

				var bubble1_radius = canvas.select('g#bubbles circle#air1').attr('r');
				var bubble2_radius = canvas.select('g#bubbles circle#air2').attr('r');
				
				// Fake animation! It doesn't move anything. I need it to avoid animations getting stuck
				// ToDo: Investigate why I need this. It seems it happens only when we have many animation chains
				// starting at the same time (like here, wave, weeds and bubbles starting at the same time)
				canvas.select('#soil').animate({transform: 't0,0'}, 3000);

				// Animate wave
				wave.animate({d:wave_path2}, 400, mina.linear, function () {
					wave.animate({d:wave_path3}, 400, mina.linear, function () {
						wave.animate({d:wave_path4}, 600, mina.linear, function () {
							wave.animate({d:wave_path1}, 1, mina.linear, function () {

								wave.animate({d:wave_path2}, 400, mina.linear, function () {
									wave.animate({d:wave_path3}, 400, mina.linear, function () {
										wave.animate({d:wave_path4}, 600, mina.linear, function () {
											wave.animate({d:wave_path1}, 1, mina.linear);
										});	
									});
								});
							});
						});	
					});
				});

				// Animate weeds
				weedsE.animate({d:weedsE_path2}, 380, mina.linear, function () {
					weedsE.animate({d:weedsE_path3}, 430, mina.linear, function () {
						weedsE.animate({d:weedsE_path1}, 520, mina.linear, function () {
							weedsE.animate({d:weedsE_path2}, 420, mina.linear, function () {
								weedsE.animate({d:weedsE_path3}, 460, mina.linear, function () {
									weedsE.animate({d:weedsE_path1}, 580, mina.linear);
								});
							});
						});
					});
				});
				weedsF.animate({d:weedsF_path3}, 520, mina.linear, function () {
					weedsF.animate({d:weedsF_path2}, 470, mina.linear, function () {
						weedsF.animate({d:weedsF_path1}, 360, mina.linear, function () {
							weedsF.animate({d:weedsF_path3}, 350, mina.linear, function () {
								weedsF.animate({d:weedsF_path2}, 500, mina.linear, function () {
									weedsF.animate({d:weedsF_path1}, 600, mina.linear);
								});
							});
						});
					});
				});
				weedsG.animate({d:weedsG_path2}, 480, mina.linear, function () {
					weedsG.animate({d:weedsG_path3}, 280, mina.linear, function () {
						weedsG.animate({d:weedsG_path1}, 530, mina.linear, function () {
							weedsG.animate({d:weedsG_path2}, 340, mina.linear, function () {
								weedsG.animate({d:weedsG_path3}, 620, mina.linear, function () {
									weedsG.animate({d:weedsG_path1}, 360, mina.linear);
								});
							});
						});
					});
				});

				// Animate bubbles
				// First thing is display them, then move and then hide again
				// Once hidden again, we move it back to start position
				bubble1.attr({display:'block'});
				bubble1.animate({transform:'t0,-60', r:7}, 2400, mina.linear, function () {
					bubble1.attr({display:'none'});
					bubble1.animate({transform:'t0,0', r:bubble1_radius}, 1);
				});

				setTimeout (function () {
					bubble2.attr({display:'block'});
					bubble2.animate({transform:'t0,-50', r:6}, 1800, mina.linear, function () {
						bubble2.attr({display:'none'});
						bubble2.animate({transform:'t0,0', r:bubble2_radius}, 1);
					});
				}, 1000);
			}
		};
		
		
		/*----------------------------------------------------------------------------
		 Public API
		----------------------------------------------------------------------------*/
		return {
			init : function(){
				init();
			}
		};
	}();
	
	
	$(function(){
		SVGAnimations.init();
	});


})( jQuery );