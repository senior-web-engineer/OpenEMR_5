<!------Tab Reviews  ---------->
								<div id="reviews" class="tab-pane col-md-9">
									
									<div class="row">
							  <ul class="nav nav-tabs">
								<li class="active"><a data-toggle="pill" href="#strength">Strength and Assets</a></li>
								<li><a href="#weakness" data-toggle="pill">Weaknesses (Limitations) or Special Needs</a></li>
							  </ul>
							</div>
						<!------Tab Strengths ---------->
		                       <div id="strength" class="tab-pane fade in active col-md-9">
									<div class="section">
										<h3>List any change in Strengths and Assets</h3>		
									<button id="addStrength" class="btn" >Add Strength</button><br/>
										<ul class="list-unstyled" id="strength_list" >
											<li class="itemList" editortype="strength_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="strength_Description"  ></textarea><br/>
											<!--
												
												
												
												
												
												
											-->
											<span  class="dev" >
												id <input type='text' id='strength_id' />
												<!--GroupID <input type='text' id='strength_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />-->
											</span>
											<!--<input type="hidden" id="diagnosis_Axis" value="1">-->
																						
											<div class="clear text-right">
												<button class="btn poststrength" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn poststrength" action="save">Save Strength</button>
											</div>
										</div>
									</div>
								</div>
							<!------End Tab Strengths ---------->							
						
							<!------Tab Weakness ---------->
							<!--weakness is from strength table -->

							<div id="weakness" class="tab-pane fade col-md-9">
									<div class="section">
										<h3>List any change in Limitations (Weaknesses) and Needs</h3>		
									<button id="addWeakness" class="btn" >Add Weakness</button><br/>
										<ul class="list-unstyled" id="weakness_list" >
											<li class="itemList" editortype="weakness_item" recid="1" ></li>
										</ul>
										
										<div class="section hidden editor" >
											<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<textarea class="textarea-sm"  id="weakness_Description"  ></textarea><br/>
											<!--
												
												
												
									
												
												
					
											-->
											<span  class="dev" >
												id <input type='text' id='weakness_id' /> 
												<!--GroupID <input type='text' id='strength_GroupID' />
												LegalCode <input type='text' id='diagnosis_LegalCode' />-->
											</span>
											<!--<input type="hidden" id="diagnosis_Axis" value="1">-->
																						
											<div class="clear text-right">
												<button class="btn postweakness" action="delete">Delete</button>
												<button class="btn cancel">Cancel</button>
												<button class="btn postsweakness" action="save">Save Weakness</button>
											</div>
										</div>
									</div>
								</div>
								<!------End Tab Weaknesses ---------->	
		
									
									
									
									
									
									
								</div>
								<!------End Tab Reviews ---------->
								