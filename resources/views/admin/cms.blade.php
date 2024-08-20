@extends('layouts.backoffice')
@section('menu-cms','active')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="website-tab" data-bs-toggle="tab" href="#website" role="tab" aria-controls="website" aria-selected="true">Edit Website</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="false">Edit Chat</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="website" role="tabpanel" aria-labelledby="website-tab">
                    @if (!empty($data->id))
                        <form id="updateForm_{{ $data->id }}" action="{{ route('cms.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col">
                                    <h5>Nama Website :</h5>
                                    <input type="text" class="form-control" name="website_name" value="{{ $data->website_name }}" />
                                </div>
                                <div class="col">
                                    <h5>Logo :</h5>
                                    <div class="row">
                                        <div class="col-3">
                                            <img style="width:100px" src="{{ asset('/assets/image_content/'.$data->logo) }}">
                                        </div>
                                        <div class="col">
                                            <input type="file" name="logo" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                                <h5>Background :</h5>
                                <div class="row">
                                    <div class="col-3">
                                        <img id="image-preview" style="width:100px" src="{{ asset('/assets/image_content/'.$data->image) }}">
                                    </div>
                                    <div class="col">
                                        <div class="grid_12">
                                            <input type="file" name="image" class="form-control" /><br>
                                            <button id="delete-button" type="button" class="btn btn-danger" data-id="{{ $data->id }}">Delete Image</button>
                                        </div>
                                    </div>
                                </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <h5>Primary Color</h5>
                                    <input type="color" name="primary_color" class="form-control" value="{{ $data->primary_color }}" />
                                </div>
                                <div class="col">
                                    <h5>Secondary Color</h5>
                                    <input type="color" name="secondary_color" class="form-control" value="{{ $data->secondary_color }}" />
                                </div>
                            </div><br>
                            <div style="text-align:right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                    @if (!empty($data_chat->id))
                        <form id="chatForm_{{ $data_chat->id }}" action="{{ route('chat_content.update', $data_chat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <label for="usernameFont" class="form-label">Font Username</label>
                                    <select id="usernameFont" name="username_font" class="form-select" onchange="updateFontPreview('usernameFontPreview', this.value)">
                                        <option value="Arial" style="font-family: Arial;" {{ $data_chat->username_font == 'Arial' ? 'selected' : '' }}>Arial<span class="font-sample" style="font-family: Arial;"></span></option>
                                        <option value="Verdana" style="font-family: Verdana;" {{ $data_chat->username_font == 'Verdana' ? 'selected' : '' }}>Verdana<span class="font-sample" style="font-family: Verdana;"></span></option>
                                        <option value="Times New Roman" style="font-family: 'Times New Roman';" {{ $data_chat->username_font == 'Times New Roman' ? 'selected' : '' }}>Times New Roman<span class="font-sample" style="font-family: 'Times New Roman';"></span></option>
                                        <option value="Courier New" style="font-family: 'Courier New';" {{ $data_chat->username_font == 'Courier New' ? 'selected' : '' }}>Courier New<span class="font-sample" style="font-family: 'Courier New';"></span></option>
                                        <option value="Georgia" style="font-family: Georgia;" {{ $data_chat->username_font == 'Georgia' ? 'selected' : '' }}>Georgia<span class="font-sample" style="font-family: Georgia;"></span></option>
                                        <option value="Comic Sans MS" style="font-family: 'Comic Sans MS';" {{ $data_chat->username_font == 'Comic Sans MS' ? 'selected' : '' }}>Comic Sans MS<span class="font-sample" style="font-family: 'Comic Sans MS';"></span></option>
                                        <option value="Trebuchet MS" style="font-family: 'Trebuchet MS';" {{ $data_chat->username_font == 'Trebuchet MS' ? 'selected' : '' }}>Trebuchet MS<span class="font-sample" style="font-family: 'Trebuchet MS';"></span></option>
                                        <option value="Lucida Sans Unicode" style="font-family: 'Lucida Sans Unicode';" {{ $data_chat->username_font == 'Lucida Sans Unicode' ? 'selected' : '' }}>Lucida Sans Unicode<span class="font-sample" style="font-family: 'Lucida Sans Unicode';"></span></option>
                                        <option value="Tahoma" style="font-family: Tahoma;" {{ $data_chat->username_font == 'Tahoma' ? 'selected' : '' }}>Tahoma<span class="font-sample" style="font-family: Tahoma;"></span></option>
                                        <option value="Arial Black" style="font-family: 'Arial Black';" {{ $data_chat->username_font == 'Arial Black' ? 'selected' : '' }}>Arial Black<span class="font-sample" style="font-family: 'Arial Black';"></span></option>
                                        <option value="Impact" style="font-family: Impact;" {{ $data_chat->username_font == 'Impact' ? 'selected' : '' }}>Impact<span class="font-sample" style="font-family: Impact;"></span></option>
                                        <option value="Palatino Linotype" style="font-family: 'Palatino Linotype';" {{ $data_chat->username_font == 'Palatino Linotype' ? 'selected' : '' }}>Palatino Linotype<span class="font-sample" style="font-family: 'Palatino Linotype';"></span></option>
                                        <option value="Garamond" style="font-family: Garamond;" {{ $data_chat->username_font == 'Garamond' ? 'selected' : '' }}>Garamond<span class="font-sample" style="font-family: Garamond;"></span></option>
                                        <option value="Bookman" style="font-family: Bookman;" {{ $data_chat->username_font == 'Bookman' ? 'selected' : '' }}>Bookman<span class="font-sample" style="font-family: Bookman;"></span></option>
                                        <option value="Arial Narrow" style="font-family: 'Arial Narrow';" {{ $data_chat->username_font == 'Arial Narrow' ? 'selected' : '' }}>Arial Narrow<span class="font-sample" style="font-family: 'Arial Narrow';"></span></option>
                                        <option value="MS Serif" style="font-family: 'MS Serif';" {{ $data_chat->username_font == 'MS Serif' ? 'selected' : '' }}>MS Serif<span class="font-sample" style="font-family: 'MS Serif';"></span></option>
                                        <option value="MS Sans Serif" style="font-family: 'MS Sans Serif';" {{ $data_chat->username_font == 'MS Sans Serif' ? 'selected' : '' }}>MS Sans Serif<span class="font-sample" style="font-family: 'MS Sans Serif';"></span></option>
                                        <option value="Helvetica" style="font-family: Helvetica;" {{ $data_chat->username_font == 'Helvetica' ? 'selected' : '' }}>Helvetica<span class="font-sample" style="font-family: Helvetica;"></span></option>
                                        <option value="Optima" style="font-family: Optima;" {{ $data_chat->username_font == 'Optima' ? 'selected' : '' }}>Optima<span class="font-sample" style="font-family: Optima;"></span></option>
                                        <option value="Candara" style="font-family: Candara;" {{ $data_chat->username_font == 'Candara' ? 'selected' : '' }}>Candara<span class="font-sample" style="font-family: Candara;"></span></option>
                                        <option value="Corbel" style="font-family: Corbel;" {{ $data_chat->username_font == 'Corbel' ? 'selected' : '' }}>Corbel<span class="font-sample" style="font-family: Corbel;"></span></option>
                                        <option value="Cambria" style="font-family: Cambria;" {{ $data_chat->username_font == 'Cambria' ? 'selected' : '' }}>Cambria<span class="font-sample" style="font-family: Cambria;"></span></option>
                                        <option value="Frank Ruhl" style="font-family: 'Frank Ruhl';" {{ $data_chat->username_font == 'Frank Ruhl' ? 'selected' : '' }}>Frank Ruhl<span class="font-sample" style="font-family: 'Frank Ruhl';"></span></option>
                                        <option value="Fira Sans" style="font-family: 'Fira Sans';" {{ $data_chat->username_font == 'Fira Sans' ? 'selected' : '' }}>Fira Sans<span class="font-sample" style="font-family: 'Fira Sans';"></span></option>
                                        <option value="Droid Sans" style="font-family: 'Droid Sans';" {{ $data_chat->username_font == 'Droid Sans' ? 'selected' : '' }}>Droid Sans<span class="font-sample" style="font-family: 'Droid Sans';"></span></option>
                                        <option value="Lato" style="font-family: Lato;" {{ $data_chat->username_font == 'Lato' ? 'selected' : '' }}>Lato<span class="font-sample" style="font-family: Lato;"></span></option>
                                        <option value="Roboto" style="font-family: Roboto;" {{ $data_chat->username_font == 'Roboto' ? 'selected' : '' }}>Roboto<span class="font-sample" style="font-family: Roboto;"></span></option>
                                        <option value="Open Sans" style="font-family: 'Open Sans';" {{ $data_chat->username_font == 'Open Sans' ? 'selected' : '' }}>Open Sans<span class="font-sample" style="font-family: 'Open Sans';"></span></option>
                                        <option value="Montserrat" style="font-family: Montserrat;" {{ $data_chat->username_font == 'Montserrat' ? 'selected' : '' }}>Montserrat<span class="font-sample" style="font-family: Montserrat;"></span></option>
                                        <option value="Raleway" style="font-family: Raleway;" {{ $data_chat->username_font == 'Raleway' ? 'selected' : '' }}>Raleway<span class="font-sample" style="font-family: Raleway;"></span></option>
                                        <option value="Source Sans Pro" style="font-family: 'Source Sans Pro';" {{ $data_chat->username_font == 'Source Sans Pro' ? 'selected' : '' }}>Source Sans Pro<span class="font-sample" style="font-family: 'Source Sans Pro';"></span></option>
                                        <option value="PT Sans" style="font-family: 'PT Sans';" {{ $data_chat->username_font == 'PT Sans' ? 'selected' : '' }}>PT Sans<span class="font-sample" style="font-family: 'PT Sans';"></span></option>
                                        <option value="Oxygen" style="font-family: Oxygen;" {{ $data_chat->username_font == 'Oxygen' ? 'selected' : '' }}>Oxygen<span class="font-sample" style="font-family: Oxygen;"></span></option>
                                        <option value="Ubuntu" style="font-family: Ubuntu;" {{ $data_chat->username_font == 'Ubuntu' ? 'selected' : '' }}>Ubuntu<span class="font-sample" style="font-family: Ubuntu;"></span></option>
                                        <option value="Noto Sans" style="font-family: 'Noto Sans';" {{ $data_chat->username_font == 'Noto Sans' ? 'selected' : '' }}>Noto Sans<span class="font-sample" style="font-family: 'Noto Sans';"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->username_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Merriweather" style="font-family: Merriweather;" {{ $data_chat->username_font == 'Merriweather' ? 'selected' : '' }}>Merriweather<span class="font-sample" style="font-family: Merriweather;"></span></option>
                                        <option value="Playfair Display" style="font-family: 'Playfair Display';" {{ $data_chat->username_font == 'Playfair Display' ? 'selected' : '' }}>Playfair Display<span class="font-sample" style="font-family: 'Playfair Display';"></span></option>
                                        <option value="Bebas Neue" style="font-family: 'Bebas Neue';" {{ $data_chat->username_font == 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue<span class="font-sample" style="font-family: 'Bebas Neue';"></span></option>
                                        <option value="Oswald" style="font-family: Oswald;" {{ $data_chat->username_font == 'Oswald' ? 'selected' : '' }}>Oswald<span class="font-sample" style="font-family: Oswald;"></span></option>
                                        <option value="Roboto Condensed" style="font-family: 'Roboto Condensed';" {{ $data_chat->username_font == 'Roboto Condensed' ? 'selected' : '' }}>Roboto Condensed<span class="font-sample" style="font-family: 'Roboto Condensed';"></span></option>
                                        <option value="Slabo 27px" style="font-family: 'Slabo 27px';" {{ $data_chat->username_font == 'Slabo 27px' ? 'selected' : '' }}>Slabo 27px<span class="font-sample" style="font-family: 'Slabo 27px';"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->username_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                        <option value="Dosis" style="font-family: Dosis;" {{ $data_chat->username_font == 'Dosis' ? 'selected' : '' }}>Dosis<span class="font-sample" style="font-family: Dosis;"></span></option>
                                        <option value="Quicksand" style="font-family: Quicksand;" {{ $data_chat->username_font == 'Quicksand' ? 'selected' : '' }}>Quicksand<span class="font-sample" style="font-family: Quicksand;"></span></option>
                                        <option value="Josefin Sans" style="font-family: 'Josefin Sans';" {{ $data_chat->username_font == 'Josefin Sans' ? 'selected' : '' }}>Josefin Sans<span class="font-sample" style="font-family: 'Josefin Sans';"></span></option>
                                        <option value="Nunito" style="font-family: Nunito;" {{ $data_chat->username_font == 'Nunito' ? 'selected' : '' }}>Nunito<span class="font-sample" style="font-family: Nunito;"></span></option>
                                        <option value="Archivo" style="font-family: Archivo;" {{ $data_chat->username_font == 'Archivo' ? 'selected' : '' }}>Archivo<span class="font-sample" style="font-family: Archivo;"></span></option>
                                        <option value="Libre Baskerville" style="font-family: 'Libre Baskerville';" {{ $data_chat->username_font == 'Libre Baskerville' ? 'selected' : '' }}>Libre Baskerville<span class="font-sample" style="font-family: 'Libre Baskerville';"></span></option>
                                        <option value="Roboto Slab" style="font-family: 'Roboto Slab';" {{ $data_chat->username_font == 'Roboto Slab' ? 'selected' : '' }}>Roboto Slab<span class="font-sample" style="font-family: 'Roboto Slab';"></span></option>
                                        <option value="Noto Serif" style="font-family: 'Noto Serif';" {{ $data_chat->username_font == 'Noto Serif' ? 'selected' : '' }}>Noto Serif<span class="font-sample" style="font-family: 'Noto Serif';"></span></option>
                                        <option value="Arimo" style="font-family: Arimo;" {{ $data_chat->username_font == 'Arimo' ? 'selected' : '' }}>Arimo<span class="font-sample" style="font-family: Arimo;"></span></option>
                                        <option value="Anton" style="font-family: Anton;" {{ $data_chat->username_font == 'Anton' ? 'selected' : '' }}>Anton<span class="font-sample" style="font-family: Anton;"></span></option>
                                        <option value="Hind" style="font-family: Hind;" {{ $data_chat->username_font == 'Hind' ? 'selected' : '' }}>Hind<span class="font-sample" style="font-family: Hind;"></span></option>
                                        <option value="Zilla Slab" style="font-family: 'Zilla Slab';" {{ $data_chat->username_font == 'Zilla Slab' ? 'selected' : '' }}>Zilla Slab<span class="font-sample" style="font-family: 'Zilla Slab';"></span></option>
                                        <option value="Fira Sans Condensed" style="font-family: 'Fira Sans Condensed';" {{ $data_chat->username_font == 'Fira Sans Condensed' ? 'selected' : '' }}>Fira Sans Condensed<span class="font-sample" style="font-family: 'Fira Sans Condensed';"></span></option>
                                        <option value="Comfortaa" style="font-family: Comfortaa;" {{ $data_chat->username_font == 'Comfortaa' ? 'selected' : '' }}>Comfortaa<span class="font-sample" style="font-family: Comfortaa;"></span></option>
                                        <option value="Yanone Kaffeesatz" style="font-family: 'Yanone Kaffeesatz';" {{ $data_chat->username_font == 'Yanone Kaffeesatz' ? 'selected' : '' }}>Yanone Kaffeesatz<span class="font-sample" style="font-family: 'Yanone Kaffeesatz';"></span></option>
                                        <option value="Varela Round" style="font-family: 'Varela Round';" {{ $data_chat->username_font == 'Varela Round' ? 'selected' : '' }}>Varela Round<span class="font-sample" style="font-family: 'Varela Round';"></span></option>
                                        <option value="Muli" style="font-family: Muli;" {{ $data_chat->username_font == 'Muli' ? 'selected' : '' }}>Muli<span class="font-sample" style="font-family: Muli;"></span></option>
                                        <option value="Gloock" style="font-family: Gloock;" {{ $data_chat->username_font == 'Gloock' ? 'selected' : '' }}>Gloock<span class="font-sample" style="font-family: Gloock;"></span></option>
                                        <option value="Cairo" style="font-family: Cairo;" {{ $data_chat->username_font == 'Cairo' ? 'selected' : '' }}>Cairo<span class="font-sample" style="font-family: Cairo;"></span></option>
                                        <option value="Sora" style="font-family: Sora;" {{ $data_chat->username_font == 'Sora' ? 'selected' : '' }}>Sora<span class="font-sample" style="font-family: Sora;"></span></option>
                                        <option value="Rokkitt" style="font-family: Rokkitt;" {{ $data_chat->username_font == 'Rokkitt' ? 'selected' : '' }}>Rokkitt<span class="font-sample" style="font-family: Rokkitt;"></span></option>
                                        <option value="Space Mono" style="font-family: 'Space Mono';" {{ $data_chat->username_font == 'Space Mono' ? 'selected' : '' }}>Space Mono<span class="font-sample" style="font-family: 'Space Mono';"></span></option>
                                        <option value="Palanquin" style="font-family: Palanquin;" {{ $data_chat->username_font == 'Palanquin' ? 'selected' : '' }}>Palanquin<span class="font-sample" style="font-family: Palanquin;"></span></option>
                                        <option value="Russo One" style="font-family: Russo One;" {{ $data_chat->username_font == 'Russo One' ? 'selected' : '' }}>Russo One<span class="font-sample" style="font-family: Russo One;"></span></option>
                                        <option value="Alegreya" style="font-family: Alegreya;" {{ $data_chat->username_font == 'Alegreya' ? 'selected' : '' }}>Alegreya<span class="font-sample" style="font-family: Alegreya;"></span></option>
                                        <option value="Andika" style="font-family: Andika;" {{ $data_chat->username_font == 'Andika' ? 'selected' : '' }}>Andika<span class="font-sample" style="font-family: Andika;"></span></option>
                                        <option value="Overpass" style="font-family: Overpass;" {{ $data_chat->username_font == 'Overpass' ? 'selected' : '' }}>Overpass<span class="font-sample" style="font-family: Overpass;"></span></option>
                                        <option value="Tisa" style="font-family: Tisa;" {{ $data_chat->username_font == 'Tisa' ? 'selected' : '' }}>Tisa<span class="font-sample" style="font-family: Tisa;"></span></option>
                                        <option value="Vollkorn" style="font-family: Vollkorn;" {{ $data_chat->username_font == 'Vollkorn' ? 'selected' : '' }}>Vollkorn<span class="font-sample" style="font-family: Vollkorn;"></span></option>
                                        <option value="Abel" style="font-family: Abel;" {{ $data_chat->username_font == 'Abel' ? 'selected' : '' }}>Abel<span class="font-sample" style="font-family: Abel;"></span></option>
                                        <option value="Alegreya Sans" style="font-family: 'Alegreya Sans';" {{ $data_chat->username_font == 'Alegreya Sans' ? 'selected' : '' }}>Alegreya Sans<span class="font-sample" style="font-family: 'Alegreya Sans';"></span></option>
                                        <option value="Arvo" style="font-family: Arvo;" {{ $data_chat->username_font == 'Arvo' ? 'selected' : '' }}>Arvo<span class="font-sample" style="font-family: Arvo;"></span></option>
                                        <option value="Baloo" style="font-family: Baloo;" {{ $data_chat->username_font == 'Baloo' ? 'selected' : '' }}>Baloo<span class="font-sample" style="font-family: Baloo;"></span></option>
                                        <option value="Cabin" style="font-family: Cabin;" {{ $data_chat->username_font == 'Cabin' ? 'selected' : '' }}>Cabin<span class="font-sample" style="font-family: Cabin;"></span></option>
                                        <option value="Cousine" style="font-family: Cousine;" {{ $data_chat->username_font == 'Cousine' ? 'selected' : '' }}>Cousine<span class="font-sample" style="font-family: Cousine;"></span></option>
                                        <option value="Dancing Script" style="font-family: 'Dancing Script';" {{ $data_chat->username_font == 'Dancing Script' ? 'selected' : '' }}>Dancing Script<span class="font-sample" style="font-family: 'Dancing Script';"></span></option>
                                        <option value="Droid Serif" style="font-family: 'Droid Serif';" {{ $data_chat->username_font == 'Droid Serif' ? 'selected' : '' }}>Droid Serif<span class="font-sample" style="font-family: 'Droid Serif';"></span></option>
                                        <option value="Exo" style="font-family: Exo;" {{ $data_chat->username_font == 'Exo' ? 'selected' : '' }}>Exo<span class="font-sample" style="font-family: Exo;"></span></option>
                                        <option value="Gloock" style="font-family: Gloock;" {{ $data_chat->username_font == 'Gloock' ? 'selected' : '' }}>Gloock<span class="font-sample" style="font-family: Gloock;"></span></option>
                                        <option value="Heebo" style="font-family: Heebo;" {{ $data_chat->username_font == 'Heebo' ? 'selected' : '' }}>Heebo<span class="font-sample" style="font-family: Heebo;"></span></option>
                                        <option value="Kanit" style="font-family: Kanit;" {{ $data_chat->username_font == 'Kanit' ? 'selected' : '' }}>Kanit<span class="font-sample" style="font-family: Kanit;"></span></option>
                                        <option value="Karla" style="font-family: Karla;" {{ $data_chat->username_font == 'Karla' ? 'selected' : '' }}>Karla<span class="font-sample" style="font-family: Karla;"></span></option>
                                        <option value="Kumbh Sans" style="font-family: Kumbh Sans;" {{ $data_chat->username_font == 'Kumbh Sans' ? 'selected' : '' }}>Kumbh Sans<span class="font-sample" style="font-family: Kumbh Sans;"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->username_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->username_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Monda" style="font-family: Monda;" {{ $data_chat->username_font == 'Monda' ? 'selected' : '' }}>Monda<span class="font-sample" style="font-family: Monda;"></span></option>
                                        <option value="Pangolin" style="font-family: Pangolin;" {{ $data_chat->username_font == 'Pangolin' ? 'selected' : '' }}>Pangolin<span class="font-sample" style="font-family: Pangolin;"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->username_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->username_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="usernameFontPreview" class="form-label">Preview Username Font</label>
                                    <div id="usernameFontPreview" style="border: 1px solid #ddd; padding: 10px; margin-top: 5px; font-family: {{ $data_chat->username_font ?? 'Arial' }};">
                                        Sample text
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <label for="chatFont" class="form-label">Font Chat</label>
                                    <select id="chatFont" name="chat_font" class="form-select" onchange="updateFontPreview('chatFontPreview', this.value)">
                                        <option value="Arial" style="font-family: Arial;" {{ $data_chat->chat_font == 'Arial' ? 'selected' : '' }}>Arial<span class="font-sample" style="font-family: Arial;"></span></option>
                                        <option value="Verdana" style="font-family: Verdana;" {{ $data_chat->chat_font == 'Verdana' ? 'selected' : '' }}>Verdana<span class="font-sample" style="font-family: Verdana;"></span></option>
                                        <option value="Times New Roman" style="font-family: 'Times New Roman';" {{ $data_chat->chat_font == 'Times New Roman' ? 'selected' : '' }}>Times New Roman<span class="font-sample" style="font-family: 'Times New Roman';"></span></option>
                                        <option value="Courier New" style="font-family: 'Courier New';" {{ $data_chat->chat_font == 'Courier New' ? 'selected' : '' }}>Courier New<span class="font-sample" style="font-family: 'Courier New';"></span></option>
                                        <option value="Georgia" style="font-family: Georgia;" {{ $data_chat->chat_font == 'Georgia' ? 'selected' : '' }}>Georgia<span class="font-sample" style="font-family: Georgia;"></span></option>
                                        <option value="Comic Sans MS" style="font-family: 'Comic Sans MS';" {{ $data_chat->chat_font == 'Comic Sans MS' ? 'selected' : '' }}>Comic Sans MS<span class="font-sample" style="font-family: 'Comic Sans MS';"></span></option>
                                        <option value="Trebuchet MS" style="font-family: 'Trebuchet MS';" {{ $data_chat->chat_font == 'Trebuchet MS' ? 'selected' : '' }}>Trebuchet MS<span class="font-sample" style="font-family: 'Trebuchet MS';"></span></option>
                                        <option value="Lucida Sans Unicode" style="font-family: 'Lucida Sans Unicode';" {{ $data_chat->chat_font == 'Lucida Sans Unicode' ? 'selected' : '' }}>Lucida Sans Unicode<span class="font-sample" style="font-family: 'Lucida Sans Unicode';"></span></option>
                                        <option value="Tahoma" style="font-family: Tahoma;" {{ $data_chat->chat_font == 'Tahoma' ? 'selected' : '' }}>Tahoma<span class="font-sample" style="font-family: Tahoma;"></span></option>
                                        <option value="Arial Black" style="font-family: 'Arial Black';" {{ $data_chat->chat_font == 'Arial Black' ? 'selected' : '' }}>Arial Black<span class="font-sample" style="font-family: 'Arial Black';"></span></option>
                                        <option value="Impact" style="font-family: Impact;" {{ $data_chat->chat_font == 'Impact' ? 'selected' : '' }}>Impact<span class="font-sample" style="font-family: Impact;"></span></option>
                                        <option value="Palatino Linotype" style="font-family: 'Palatino Linotype';" {{ $data_chat->chat_font == 'Palatino Linotype' ? 'selected' : '' }}>Palatino Linotype<span class="font-sample" style="font-family: 'Palatino Linotype';"></span></option>
                                        <option value="Garamond" style="font-family: Garamond;" {{ $data_chat->chat_font == 'Garamond' ? 'selected' : '' }}>Garamond<span class="font-sample" style="font-family: Garamond;"></span></option>
                                        <option value="Bookman" style="font-family: Bookman;" {{ $data_chat->chat_font == 'Bookman' ? 'selected' : '' }}>Bookman<span class="font-sample" style="font-family: Bookman;"></span></option>
                                        <option value="Arial Narrow" style="font-family: 'Arial Narrow';" {{ $data_chat->chat_font == 'Arial Narrow' ? 'selected' : '' }}>Arial Narrow<span class="font-sample" style="font-family: 'Arial Narrow';"></span></option>
                                        <option value="MS Serif" style="font-family: 'MS Serif';" {{ $data_chat->chat_font == 'MS Serif' ? 'selected' : '' }}>MS Serif<span class="font-sample" style="font-family: 'MS Serif';"></span></option>
                                        <option value="MS Sans Serif" style="font-family: 'MS Sans Serif';" {{ $data_chat->chat_font == 'MS Sans Serif' ? 'selected' : '' }}>MS Sans Serif<span class="font-sample" style="font-family: 'MS Sans Serif';"></span></option>
                                        <option value="Helvetica" style="font-family: Helvetica;" {{ $data_chat->chat_font == 'Helvetica' ? 'selected' : '' }}>Helvetica<span class="font-sample" style="font-family: Helvetica;"></span></option>
                                        <option value="Optima" style="font-family: Optima;" {{ $data_chat->chat_font == 'Optima' ? 'selected' : '' }}>Optima<span class="font-sample" style="font-family: Optima;"></span></option>
                                        <option value="Candara" style="font-family: Candara;" {{ $data_chat->chat_font == 'Candara' ? 'selected' : '' }}>Candara<span class="font-sample" style="font-family: Candara;"></span></option>
                                        <option value="Corbel" style="font-family: Corbel;" {{ $data_chat->chat_font == 'Corbel' ? 'selected' : '' }}>Corbel<span class="font-sample" style="font-family: Corbel;"></span></option>
                                        <option value="Cambria" style="font-family: Cambria;" {{ $data_chat->chat_font == 'Cambria' ? 'selected' : '' }}>Cambria<span class="font-sample" style="font-family: Cambria;"></span></option>
                                        <option value="Frank Ruhl" style="font-family: 'Frank Ruhl';" {{ $data_chat->chat_font == 'Frank Ruhl' ? 'selected' : '' }}>Frank Ruhl<span class="font-sample" style="font-family: 'Frank Ruhl';"></span></option>
                                        <option value="Fira Sans" style="font-family: 'Fira Sans';" {{ $data_chat->chat_font == 'Fira Sans' ? 'selected' : '' }}>Fira Sans<span class="font-sample" style="font-family: 'Fira Sans';"></span></option>
                                        <option value="Droid Sans" style="font-family: 'Droid Sans';" {{ $data_chat->chat_font == 'Droid Sans' ? 'selected' : '' }}>Droid Sans<span class="font-sample" style="font-family: 'Droid Sans';"></span></option>
                                        <option value="Lato" style="font-family: Lato;" {{ $data_chat->chat_font == 'Lato' ? 'selected' : '' }}>Lato<span class="font-sample" style="font-family: Lato;"></span></option>
                                        <option value="Roboto" style="font-family: Roboto;" {{ $data_chat->chat_font == 'Roboto' ? 'selected' : '' }}>Roboto<span class="font-sample" style="font-family: Roboto;"></span></option>
                                        <option value="Open Sans" style="font-family: 'Open Sans';" {{ $data_chat->chat_font == 'Open Sans' ? 'selected' : '' }}>Open Sans<span class="font-sample" style="font-family: 'Open Sans';"></span></option>
                                        <option value="Montserrat" style="font-family: Montserrat;" {{ $data_chat->chat_font == 'Montserrat' ? 'selected' : '' }}>Montserrat<span class="font-sample" style="font-family: Montserrat;"></span></option>
                                        <option value="Raleway" style="font-family: Raleway;" {{ $data_chat->chat_font == 'Raleway' ? 'selected' : '' }}>Raleway<span class="font-sample" style="font-family: Raleway;"></span></option>
                                        <option value="Source Sans Pro" style="font-family: 'Source Sans Pro';" {{ $data_chat->chat_font == 'Source Sans Pro' ? 'selected' : '' }}>Source Sans Pro<span class="font-sample" style="font-family: 'Source Sans Pro';"></span></option>
                                        <option value="PT Sans" style="font-family: 'PT Sans';" {{ $data_chat->chat_font == 'PT Sans' ? 'selected' : '' }}>PT Sans<span class="font-sample" style="font-family: 'PT Sans';"></span></option>
                                        <option value="Oxygen" style="font-family: Oxygen;" {{ $data_chat->chat_font == 'Oxygen' ? 'selected' : '' }}>Oxygen<span class="font-sample" style="font-family: Oxygen;"></span></option>
                                        <option value="Ubuntu" style="font-family: Ubuntu;" {{ $data_chat->chat_font == 'Ubuntu' ? 'selected' : '' }}>Ubuntu<span class="font-sample" style="font-family: Ubuntu;"></span></option>
                                        <option value="Noto Sans" style="font-family: 'Noto Sans';" {{ $data_chat->chat_font == 'Noto Sans' ? 'selected' : '' }}>Noto Sans<span class="font-sample" style="font-family: 'Noto Sans';"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->chat_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Merriweather" style="font-family: Merriweather;" {{ $data_chat->chat_font == 'Merriweather' ? 'selected' : '' }}>Merriweather<span class="font-sample" style="font-family: Merriweather;"></span></option>
                                        <option value="Playfair Display" style="font-family: 'Playfair Display';" {{ $data_chat->chat_font == 'Playfair Display' ? 'selected' : '' }}>Playfair Display<span class="font-sample" style="font-family: 'Playfair Display';"></span></option>
                                        <option value="Bebas Neue" style="font-family: 'Bebas Neue';" {{ $data_chat->chat_font == 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue<span class="font-sample" style="font-family: 'Bebas Neue';"></span></option>
                                        <option value="Oswald" style="font-family: Oswald;" {{ $data_chat->chat_font == 'Oswald' ? 'selected' : '' }}>Oswald<span class="font-sample" style="font-family: Oswald;"></span></option>
                                        <option value="Roboto Condensed" style="font-family: 'Roboto Condensed';" {{ $data_chat->chat_font == 'Roboto Condensed' ? 'selected' : '' }}>Roboto Condensed<span class="font-sample" style="font-family: 'Roboto Condensed';"></span></option>
                                        <option value="Slabo 27px" style="font-family: 'Slabo 27px';" {{ $data_chat->chat_font == 'Slabo 27px' ? 'selected' : '' }}>Slabo 27px<span class="font-sample" style="font-family: 'Slabo 27px';"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->chat_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                        <option value="Dosis" style="font-family: Dosis;" {{ $data_chat->chat_font == 'Dosis' ? 'selected' : '' }}>Dosis<span class="font-sample" style="font-family: Dosis;"></span></option>
                                        <option value="Quicksand" style="font-family: Quicksand;" {{ $data_chat->chat_font == 'Quicksand' ? 'selected' : '' }}>Quicksand<span class="font-sample" style="font-family: Quicksand;"></span></option>
                                        <option value="Josefin Sans" style="font-family: 'Josefin Sans';" {{ $data_chat->chat_font == 'Josefin Sans' ? 'selected' : '' }}>Josefin Sans<span class="font-sample" style="font-family: 'Josefin Sans';"></span></option>
                                        <option value="Nunito" style="font-family: Nunito;" {{ $data_chat->chat_font == 'Nunito' ? 'selected' : '' }}>Nunito<span class="font-sample" style="font-family: Nunito;"></span></option>
                                        <option value="Archivo" style="font-family: Archivo;" {{ $data_chat->chat_font == 'Archivo' ? 'selected' : '' }}>Archivo<span class="font-sample" style="font-family: Archivo;"></span></option>
                                        <option value="Libre Baskerville" style="font-family: 'Libre Baskerville';" {{ $data_chat->chat_font == 'Libre Baskerville' ? 'selected' : '' }}>Libre Baskerville<span class="font-sample" style="font-family: 'Libre Baskerville';"></span></option>
                                        <option value="Roboto Slab" style="font-family: 'Roboto Slab';" {{ $data_chat->chat_font == 'Roboto Slab' ? 'selected' : '' }}>Roboto Slab<span class="font-sample" style="font-family: 'Roboto Slab';"></span></option>
                                        <option value="Noto Serif" style="font-family: 'Noto Serif';" {{ $data_chat->chat_font == 'Noto Serif' ? 'selected' : '' }}>Noto Serif<span class="font-sample" style="font-family: 'Noto Serif';"></span></option>
                                        <option value="Arimo" style="font-family: Arimo;" {{ $data_chat->chat_font == 'Arimo' ? 'selected' : '' }}>Arimo<span class="font-sample" style="font-family: Arimo;"></span></option>
                                        <option value="Anton" style="font-family: Anton;" {{ $data_chat->chat_font == 'Anton' ? 'selected' : '' }}>Anton<span class="font-sample" style="font-family: Anton;"></span></option>
                                        <option value="Hind" style="font-family: Hind;" {{ $data_chat->chat_font == 'Hind' ? 'selected' : '' }}>Hind<span class="font-sample" style="font-family: Hind;"></span></option>
                                        <option value="Zilla Slab" style="font-family: 'Zilla Slab';" {{ $data_chat->chat_font == 'Zilla Slab' ? 'selected' : '' }}>Zilla Slab<span class="font-sample" style="font-family: 'Zilla Slab';"></span></option>
                                        <option value="Fira Sans Condensed" style="font-family: 'Fira Sans Condensed';" {{ $data_chat->chat_font == 'Fira Sans Condensed' ? 'selected' : '' }}>Fira Sans Condensed<span class="font-sample" style="font-family: 'Fira Sans Condensed';"></span></option>
                                        <option value="Comfortaa" style="font-family: Comfortaa;" {{ $data_chat->chat_font == 'Comfortaa' ? 'selected' : '' }}>Comfortaa<span class="font-sample" style="font-family: Comfortaa;"></span></option>
                                        <option value="Yanone Kaffeesatz" style="font-family: 'Yanone Kaffeesatz';" {{ $data_chat->chat_font == 'Yanone Kaffeesatz' ? 'selected' : '' }}>Yanone Kaffeesatz<span class="font-sample" style="font-family: 'Yanone Kaffeesatz';"></span></option>
                                        <option value="Varela Round" style="font-family: 'Varela Round';" {{ $data_chat->chat_font == 'Varela Round' ? 'selected' : '' }}>Varela Round<span class="font-sample" style="font-family: 'Varela Round';"></span></option>
                                        <option value="Muli" style="font-family: Muli;" {{ $data_chat->chat_font == 'Muli' ? 'selected' : '' }}>Muli<span class="font-sample" style="font-family: Muli;"></span></option>
                                        <option value="Gloock" style="font-family: Gloock;" {{ $data_chat->chat_font == 'Gloock' ? 'selected' : '' }}>Gloock<span class="font-sample" style="font-family: Gloock;"></span></option>
                                        <option value="Cairo" style="font-family: Cairo;" {{ $data_chat->chat_font == 'Cairo' ? 'selected' : '' }}>Cairo<span class="font-sample" style="font-family: Cairo;"></span></option>
                                        <option value="Sora" style="font-family: Sora;" {{ $data_chat->chat_font == 'Sora' ? 'selected' : '' }}>Sora<span class="font-sample" style="font-family: Sora;"></span></option>
                                        <option value="Rokkitt" style="font-family: Rokkitt;" {{ $data_chat->chat_font == 'Rokkitt' ? 'selected' : '' }}>Rokkitt<span class="font-sample" style="font-family: Rokkitt;"></span></option>
                                        <option value="Space Mono" style="font-family: 'Space Mono';" {{ $data_chat->chat_font == 'Space Mono' ? 'selected' : '' }}>Space Mono<span class="font-sample" style="font-family: 'Space Mono';"></span></option>
                                        <option value="Palanquin" style="font-family: Palanquin;" {{ $data_chat->chat_font == 'Palanquin' ? 'selected' : '' }}>Palanquin<span class="font-sample" style="font-family: Palanquin;"></span></option>
                                        <option value="Russo One" style="font-family: Russo One;" {{ $data_chat->chat_font == 'Russo One' ? 'selected' : '' }}>Russo One<span class="font-sample" style="font-family: Russo One;"></span></option>
                                        <option value="Alegreya" style="font-family: Alegreya;" {{ $data_chat->chat_font == 'Alegreya' ? 'selected' : '' }}>Alegreya<span class="font-sample" style="font-family: Alegreya;"></span></option>
                                        <option value="Andika" style="font-family: Andika;" {{ $data_chat->chat_font == 'Andika' ? 'selected' : '' }}>Andika<span class="font-sample" style="font-family: Andika;"></span></option>
                                        <option value="Overpass" style="font-family: Overpass;" {{ $data_chat->chat_font == 'Overpass' ? 'selected' : '' }}>Overpass<span class="font-sample" style="font-family: Overpass;"></span></option>
                                        <option value="Tisa" style="font-family: Tisa;" {{ $data_chat->chat_font == 'Tisa' ? 'selected' : '' }}>Tisa<span class="font-sample" style="font-family: Tisa;"></span></option>
                                        <option value="Vollkorn" style="font-family: Vollkorn;" {{ $data_chat->chat_font == 'Vollkorn' ? 'selected' : '' }}>Vollkorn<span class="font-sample" style="font-family: Vollkorn;"></span></option>
                                        <option value="Abel" style="font-family: Abel;" {{ $data_chat->chat_font == 'Abel' ? 'selected' : '' }}>Abel<span class="font-sample" style="font-family: Abel;"></span></option>
                                        <option value="Alegreya Sans" style="font-family: 'Alegreya Sans';" {{ $data_chat->chat_font == 'Alegreya Sans' ? 'selected' : '' }}>Alegreya Sans<span class="font-sample" style="font-family: 'Alegreya Sans';"></span></option>
                                        <option value="Arvo" style="font-family: Arvo;" {{ $data_chat->chat_font == 'Arvo' ? 'selected' : '' }}>Arvo<span class="font-sample" style="font-family: Arvo;"></span></option>
                                        <option value="Baloo" style="font-family: Baloo;" {{ $data_chat->chat_font == 'Baloo' ? 'selected' : '' }}>Baloo<span class="font-sample" style="font-family: Baloo;"></span></option>
                                        <option value="Cabin" style="font-family: Cabin;" {{ $data_chat->chat_font == 'Cabin' ? 'selected' : '' }}>Cabin<span class="font-sample" style="font-family: Cabin;"></span></option>
                                        <option value="Cousine" style="font-family: Cousine;" {{ $data_chat->chat_font == 'Cousine' ? 'selected' : '' }}>Cousine<span class="font-sample" style="font-family: Cousine;"></span></option>
                                        <option value="Dancing Script" style="font-family: 'Dancing Script';" {{ $data_chat->chat_font == 'Dancing Script' ? 'selected' : '' }}>Dancing Script<span class="font-sample" style="font-family: 'Dancing Script';"></span></option>
                                        <option value="Droid Serif" style="font-family: 'Droid Serif';" {{ $data_chat->chat_font == 'Droid Serif' ? 'selected' : '' }}>Droid Serif<span class="font-sample" style="font-family: 'Droid Serif';"></span></option>
                                        <option value="Exo" style="font-family: Exo;" {{ $data_chat->chat_font == 'Exo' ? 'selected' : '' }}>Exo<span class="font-sample" style="font-family: Exo;"></span></option>
                                        <option value="Gloock" style="font-family: Gloock;" {{ $data_chat->chat_font == 'Gloock' ? 'selected' : '' }}>Gloock<span class="font-sample" style="font-family: Gloock;"></span></option>
                                        <option value="Heebo" style="font-family: Heebo;" {{ $data_chat->chat_font == 'Heebo' ? 'selected' : '' }}>Heebo<span class="font-sample" style="font-family: Heebo;"></span></option>
                                        <option value="Kanit" style="font-family: Kanit;" {{ $data_chat->chat_font == 'Kanit' ? 'selected' : '' }}>Kanit<span class="font-sample" style="font-family: Kanit;"></span></option>
                                        <option value="Karla" style="font-family: Karla;" {{ $data_chat->chat_font == 'Karla' ? 'selected' : '' }}>Karla<span class="font-sample" style="font-family: Karla;"></span></option>
                                        <option value="Kumbh Sans" style="font-family: Kumbh Sans;" {{ $data_chat->chat_font == 'Kumbh Sans' ? 'selected' : '' }}>Kumbh Sans<span class="font-sample" style="font-family: Kumbh Sans;"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->chat_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Lora" style="font-family: Lora;" {{ $data_chat->chat_font == 'Lora' ? 'selected' : '' }}>Lora<span class="font-sample" style="font-family: Lora;"></span></option>
                                        <option value="Monda" style="font-family: Monda;" {{ $data_chat->chat_font == 'Monda' ? 'selected' : '' }}>Monda<span class="font-sample" style="font-family: Monda;"></span></option>
                                        <option value="Pangolin" style="font-family: Pangolin;" {{ $data_chat->chat_font == 'Pangolin' ? 'selected' : '' }}>Pangolin<span class="font-sample" style="font-family: Pangolin;"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->chat_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                        <option value="Poppins" style="font-family: Poppins;" {{ $data_chat->chat_font == 'Poppins' ? 'selected' : '' }}>Poppins<span class="font-sample" style="font-family: Poppins;"></span></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="chatFontPreview" class="form-label">Preview Chat Font</label>
                                    <div id="chatFontPreview" style="border: 1px solid #ddd; padding: 10px; margin-top: 5px; font-family: {{ $data_chat->chat_font ?? 'Arial' }};">
                                        Sample text
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                <label for="chatFontPreview" class="form-label">Chat Name Size</label>
                                    <input class="form-control" type="number" min="0" name="chat_sizeName" value="{{ $data_chat->chat_sizeName }}">
                                </div>
                                <div class="col">
                                    <label for="chatFontPreview" class="form-label">Chat Size</label>
                                    <input class="form-control" type="number" min="0" name="chat_size" value="{{ $data_chat->chat_size }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="usernameColor" class="form-label">Color Username And Chat</label>
                                    <input type="color" id="usernameColor" name="username_color" class="form-control"  value="{{ $data_chat->username_color }}"/>
                                </div>
                                <div class="col">
                                    <label for="chatColor" class="form-label">Color Chat Box</label>
                                    <input type="color" id="chatColor" name="chat_color" class="form-control"  value="{{ $data_chat->chat_color }}"/>
                                </div>
                            </div><br>
                            <div style="text-align:right">
                                <button type="submit" class="btn btn-primary">Save Chat Settings</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function updateFontPreview(previewId, fontFamily) {
        var previewElement = document.getElementById(previewId);
        if (previewElement) {
            previewElement.style.fontFamily = fontFamily;
        } else {
            console.error('Elemen preview dengan ID ' + previewId + ' tidak ditemukan.');
        }
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formId = this.id;
            const formData = new FormData(this);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!csrfToken) {
                console.error('CSRF token not found.');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to save changes!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Network response was not ok.');
                    }).then(data => {
                        Swal.fire(
                            'Saved!',
                            'Your changes have been saved.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error!',
                            'There was an error saving your changes.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        updateFontPreview('usernameFontPreview', document.getElementById('usernameFont').value);
        updateFontPreview('chatFontPreview', document.getElementById('chatFont').value);

        const deleteButton = document.getElementById('delete-button');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (deleteButton) {
            deleteButton.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const deleteUrl = `{{ url('/cms') }}/${id}/image`;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to recover this image!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire(
                                'Deleted!',
                                data.success, // Menggunakan pesan sukses dari respons JSON
                                'success'
                            ).then(() => {
                                // Update atau hapus preview gambar
                                document.getElementById('image-preview').src = '{{ asset('/assets/image_content/default-image.jpg') }}';
                            });
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the image.',
                                'error'
                            );
                        });
                    }
                });
            });
        }
    });
</script>
@endpush