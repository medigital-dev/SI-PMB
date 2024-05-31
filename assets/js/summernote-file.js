/**
 * Copyright 2019 [nobsod | Mathieu Coingt].
 * Website: https://www.nobsod.fr
 * Email: dev@nobsod.fr
 * License: MIT
 *
 * Fork from summernote-audio : https://github.com/taalendigitaal/summernote-audio
 */
(function (factory) {
	/* Global define */
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof module === 'object' && module.exports) {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(window.jQuery);
	}
}(function ($) {
	$.extend(true, $.summernote.lang, {
		'en-US': {
			file: {
				file: 'File',
				btn: 'File',
				insert: 'Tambah File',
				selectFromFiles: 'Pilih file',
				url: 'Alamat berkas',
				maximumFileSize: 'Maximum file size',
				maximumFileSizeError: 'Maximum file size exceeded.'
			}
		},
		'fr-FR': {
			file: {
				file: 'Fichier',
				btn: 'Fichier',
				insert: 'Insérer un fichier',
				selectFromFiles: 'Sélectionner depuis les fichiers',
				url: 'URL du fichier',
				maximumFileSize: 'Poids maximum du fichier',
				maximumFileSizeError: 'Poids maximum dépassé.'
			}
		},
		'cs-CZ': {
			file: {
				file: 'Soubor',
				btn: 'Soubor',
				insert: 'Vložit soubor',
				selectFromFiles: 'Vybrat ze souborů',
				url: 'URL souboru',
				maximumFileSize: 'Maximální velikost souboru',
				maximumFileSizeError: 'Maximální velikost souboru překročena.'
			}
		},
	});
	
	$.extend($.summernote.options, {
		file: {
			icon: '<i class="fas fa-upload"></i>'
		},
		callbacks: {
			onFileUpload: null,
			onFileUploadError: null,
			onFileLinkInsert: null
		}
	});
	
	$.extend($.summernote.plugins, {
		/**
		 *  @param {Object} context - context object has status of editor.
		 */
		'file': function (context) {
			let self = this,
				// ui has renders to build ui elements
				// for e.g. you can create a button with 'ui.button'
				ui = $.summernote.ui,
				$note = context.layoutInfo.note,
				// contentEditable element
				$editor = context.layoutInfo.editor,
				$editable = context.layoutInfo.editable,
				$toolbar = context.layoutInfo.toolbar,
				// options holds the Options Information from Summernote and what we extended above.
				options = context.options,
				// lang holds the Language Information from Summernote and what we extended above.
				lang = options.langInfo;
			
			context.memo('button.file', function () {
				// Here we create a button
				let button = ui.button({
					// icon for button
					contents: options.file.icon,
					
					// tooltip for button
					tooltip: lang.file.file,
					click: function (e) {
						context.invoke('file.show');
					}
				});
				return button.render();
			});
			
			this.initialize = function () {
				// This is how we can add a Modal Dialog to allow users to interact with the Plugin.
				
				// get the correct container for the plugin how it's attached to the document DOM.
				let $container = options.dialogsInBody ? $(document.body) : $editor;
				
				let fileLimitation = '';
				if (options.maximumFileSize) {
					let unit = Math.floor(Math.log(options.maximumFileSize) / Math.log(1024));
					let readableSize = (options.maximumFileSize / Math.pow(1024, unit)).toFixed(2) * 1 +
						' ' + ' KMGTP'[unit] + 'B';
					fileLimitation = '<small>' + lang.file.maximumFileSize + ' : ' + readableSize + '</small>';
				}
				
				// Build the Body HTML of the Dialog.
				let body = [
					'<div class="accordion" id="accordionFlushExample"><div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">Upload File</button></h2><div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample"><div class="accordion-body">',
					'<label class="note-form-label form-label">' + lang.file.selectFromFiles + '</label>',
					'<div class="input-group note-form-group note-group-select-from-files mb-2">',
						'<input class="note-file-input note-form-control note-input form-control" type="file" name="files" accept="*/*" id="fileInput" multiple>',
						'<div class="invalid-feedback">Pilih file terlebih dahulu!</div>',
					'</div>',
					'<ul class="list-group mb-3" id="multiFile"></ul>',
					'<div class="d-flex justify-content-center"><button type="button" class="btn btn-outline-primary note-file-upload">Upload</button></div>',
					fileLimitation,
					'</div></div></div><div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">Insert Link</button></h2><div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample"><div class="accordion-body">',
					'<label class="note-form-label form-label">' + lang.file.url + '</label>',
					'<div class="input-group note-group-image-url">',
					'<input class="note-file-url form-control note-form-control note-input" placeholder="Paste di sini" type="text">',
					'<button href="#" class="btn btn-outline-primary note-file-btn">' + lang.file.insert + '</button>	',
					'<div class="invalid-feedback">Paste alamat file terlebih dahulu!</div>',
					'</div></div></div></div></div>'
				].join('');
				
				// Build the Footer HTML of the Dialog.
				let footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>';
				
				this.$dialog = ui.dialog({
					
					// Set the title for the Dialog. Note: We don't need to build the markup for the Modal
					// Header, we only need to set the Title.
					title: lang.file.insert,
					
					// Set the Body of the Dialog.
					body: body,
					
					// Set the Footer of the Dialog.
					footer: footer
					
					// This adds the Modal to the DOM.
				}).render().appendTo($container);
			};
			
			this.destroy = function () {
				ui.hideDialog(this.$dialog);
				this.$dialog.remove();
			};
			
			this.bindEnterKey = function ($input, $btn) {
				$input.on('keypress', function (event) {
					if (event.keyCode === 13)
						$btn.trigger('click');
				});
			};
			
			this.bindLabels = function () {
				self.$dialog.find('.form-control:first').focus().select();
				self.$dialog.find('label').on('click', function () {
					$(this).parent().find('.form-control:first').focus();
				});
			};
			
			/**
			 * @method readFileAsDataURL
			 *
			 * read contents of file as representing URL
			 *
			 * @param {File} file
			 * @return {Promise} - then: dataUrl
			 *
			 * @todo this method already exists in summernote.js so we should use that one
			 */
			this.readFileAsDataURL = function (file) {
				return $.Deferred(function (deferred) {
					$.extend(new FileReader(), {
						onload: function (e) {
							let dataURL = e.target.result;
							deferred.resolve(dataURL);
						},
						onerror: function (err) {
							deferred.reject(err);
						}
					}).readAsDataURL(file);
				}).promise();
			};
			
			this.createFile = function (url) {
				// IMG url patterns (jpg, jpeg, png, gif, svg, webp)
				let imgRegExp = /^.+.(jpg|jpeg|png|gif|svg|webp)$/;
				let imgBase64RegExp = /^data:(image\/jpeg|image\/png|image\/gif|image\/svg|image\/webp).+$/;
				
				// AUDIO url patterns (mp3, ogg, oga)
				let audioRegExp = /^.+.(mp3|ogg|oga)$/;
				let audioBase64RegExp = /^data:(audio\/mpeg|audio\/ogg).+$/;
				
				// VIDEO url patterns (mp4, ogc, webm)
				let videoRegExp = /^.+.(mp4|ogv|webm)$/;
				let videoBase64RegExp = /^data:(video\/mpeg|video\/mp4|video\/ogv|video\/webm).+$/;
				
				let $file;
				if (url.match(imgRegExp) || url.match(imgBase64RegExp)) {
					$file = $('<img>')
						.attr('src', url)
					;
				} else if (url.match(audioRegExp) || url.match(audioBase64RegExp)) {
					$file = $('<audio controls>')
						.attr('src', url)
					;
				} else if (url.match(videoRegExp) || url.match(videoBase64RegExp)) {
					$file = $('<video controls>')
						.attr('src', url)
					;
				} else {
					//We can't use this type of file. You have to implement onFileUpload into your Summernote
					console.log('File type not supported. Please define "onFileUpload" callback in Summernote.');
					Swal.fire('info', 'File type not supported. Please define "onFileUpload" callback in Summernote.');
					return false;
				}
				
				$file.addClass('note-file-clip');
				
				return $file;
			};
			
			this.insertFile = function (src, param) {
				let $file = self.createFile(src);
				
				if (!$file) {
					context.triggerEvent('file.upload.error');
				}
				
				context.invoke('editor.beforeCommand');
				
				if (typeof param === 'string') {
					$file.attr('data-filename', param);
				}
				
				$file.show();
				context.invoke('editor.insertNode', $file[0]);
				
				context.invoke('editor.afterCommand');
			};
			
			this.insertFilesAsDataURL = function (files) {
				$.each(files, function (idx, file) {
					let filename = file.name;
					if (options.maximumFileSize && options.maximumFileSize < file.size) {
						context.triggerEvent('file.upload.error', lang.file.maximumFileSizeError);
					} else {
						self.readFileAsDataURL(file).then(function (dataURL) {
							return self.insertFile(dataURL, filename);
						}).fail(function () {
							context.triggerEvent('file.upload.error');
						});
					}
				});
			};
			
			this.show = function (data) {
				context.invoke('editor.saveRange');
				this.showFileDialog().then(function (data) {
					// [workaround] hide dialog before restore range for IE range focus
					ui.hideDialog(self.$dialog);
					context.invoke('editor.restoreRange');
					
					if (typeof data === 'string') { // file url
						// If onFileLinkInsert set
						if (options.callbacks.onFileLinkInsert) {
							context.triggerEvent('file.link.insert', data);
						} else {
							self.insertFile(data);
						}
					} else { // array of files
						// If onFileUpload set
						if (options.callbacks.onFileUpload) {
							context.triggerEvent('file.upload', data);
						} else {
							// else insert File as dataURL
							self.insertFilesAsDataURL(data);
						}
					}
				}).fail(function () {
					context.invoke('editor.restoreRange');
				});
			};
			this.showFileDialog = function () {
				return $.Deferred(function (deferred) {
					let $fileInput = self.$dialog.find('.note-file-input');
					let $fileUrl = self.$dialog.find('.note-file-url');
					let $fileBtn = self.$dialog.find('.note-file-btn');
					let $btnUpload = self.$dialog.find('.note-file-upload');
					
					ui.onDialogShown(self.$dialog, function () {
						context.triggerEvent('dialog.shown');

						$btnUpload.on('click', ()=>{
							if($fileInput.val() == ''){
								$('#fileInput').addClass('is-invalid');
								return;
							}							
							deferred.resolve($fileInput.prop('files') || $fileInput.val());
						});
						
						$fileInput.on('change',e=>{
							let berkas = e.target.files;
							if(berkas.length > 0){
								$('#multiFile').removeClass('d-none').html('');
								for (let i = 0; i < berkas.length; i++) {
									let reader = new FileReader();
									reader.onload= event=>{
										const element = berkas[i];
										const tipe = element.type.split('/');
										const ext = getFileExtension(element.name);
										const icon = getFileIcon(ext);
										const size = (element.size /(1024*1024)).toFixed(2);
										const isPdf = ext=='pdf'?'data-type="pdf"':'';
										const preview = '<a href="'+event.target.result+'" data-fancybox="fileUpload" '+isPdf+'>'+icon+'</a>';
										const newElemen = '<li class="list-group-item list-group-item-action d-flex gap-3 py-3">'+
										preview+ 
										'<div class="d-flex gap-2 w-100 justify-content-between">'+
										'['+size+'Mb] '+ element.name+
										'<a class="text-decoration-none text-danger" type="button" onclick="removeFileInput('+i+')"><i class="fas fa-times-circle"></i></a>'+
										'</div>'+
										  '</li>';
										$('#multiFile').append(newElemen);
									}
									reader.readAsDataURL(berkas[i]);									
								}
							} else {
								$('#multiFile').addClass('d-none').html('');
							}
						});
						
						$fileBtn.click(function (e) {
							e.preventDefault();
							if($fileUrl.val()==''){
								$fileUrl.addClass('is-invalid');
								return;
							}
							deferred.resolve($fileUrl.val());
						});
						
						$fileUrl.on('keyup paste', function () {
							let url = $fileUrl.val();
							ui.toggleBtn($fileBtn, url);
						}).val('');
						
						self.bindEnterKey($fileUrl, $fileBtn);
						self.bindLabels();
					});
					ui.onDialogHidden(self.$dialog, function () {
						$fileInput.off('change').removeClass('is-invalid').val('');
						$fileUrl.off('keyup paste keypress').removeClass('is-invalid');
						$fileBtn.off('click');
						$('#multiFile').html('');

						if (deferred.state() === 'pending')
							deferred.reject();
					});
					ui.showDialog(self.$dialog);
				});
			};
		}
	});
}));