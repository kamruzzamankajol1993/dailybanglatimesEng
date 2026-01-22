@extends('front.master.master')

@section('title')
Contact Us
@endsection

@section('css')
<style>
        .contact-icon-box {
            width: 60px;
            height: 60px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
            transition: all 0.3s ease;
            color: #dc3545;
            border: 1px solid #dee2e6;
        }
        .contact-card:hover .contact-icon-box {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        .dept-list li {
            padding: 10px 0;
            border-bottom: 1px dashed #ddd;
            display: flex;
            justify-content: space-between;
        }
        .dept-list li:last-child { border-bottom: none; }
    </style>
@endsection


@section('body')
 <div class="container py-5">
        
        {{-- Success Message Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <strong>Thank You!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Contact Info Cards (4 Columns Now) --}}
        <div class="row g-3 mb-5">
            
            {{-- USA Office --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm p-3 contact-card">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon-box flex-shrink-0">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Head office (USA)</h6>
                            <p class="text-secondary small mb-0">{{ $front_us_office_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bangladesh Office (New Column) --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm p-3 contact-card">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon-box flex-shrink-0">
                            <i class="fas fa-building fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Bangladesh Office</h6>
                            <p class="text-secondary small mb-0">{{$front_ins_add}}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phone --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm p-3 contact-card">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon-box flex-shrink-0">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Phone </h6>
                            <p class="text-secondary small mb-0">{{ $front_ins_phone }}<br>{{ $front_ins_phone_one }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm p-3 contact-card">
                    <div class="d-flex align-items-start">
                        <div class="contact-icon-box flex-shrink-0">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-secondary small mb-0">
                                {{$front_ins_email}}<br>
                                {{$front_email_one}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            {{-- Contact Form Section --}}
            <div class="col-lg-7">
                <div class="bg-white p-4 shadow-sm border h-100">
                    <div class="section-header-wrapper mb-4" style="border-bottom: 2px solid #dc3545;">
                        <h4 class="bg-success text-white d-inline-block px-3 py-2 m-0 fw-bold">Send Message</h4>
                    </div>
                    
                    <form action="{{ route('front.contactUsPost') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control rounded-0 bg-light border-0" id="name" placeholder="Your name" required>
                                    <label for="name">Your name *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control rounded-0 bg-light border-0" id="email" placeholder="Email" required>
                                    <label for="email">Email *</label>
                                </div>
                            </div>
                            
                            {{-- Phone Field Added --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="phone" class="form-control rounded-0 bg-light border-0" id="phone" placeholder="Phone number">
                                    <label for="phone">Phone number (Optional)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="subject" class="form-select rounded-0 bg-light border-0" id="subject" required>
                                        <option value="" selected disabled>Select Subject</option>
                                        <option value="Press Release">Press Release</option>
                                        <option value="Advertisement Related">Advertisement Related</option>
                                        <option value="Feedback / Complaint">Feedback / Complaint</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label for="subject">Subject *</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="message" class="form-control rounded-0 bg-light border-0" placeholder="Message" id="message" style="height: 150px" required></textarea>
                                    <label for="message">Type Your Message... *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger rounded-0 px-5 py-2 fw-bold w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Map & Department Section --}}
            <div class="col-lg-5">
                <div class="bg-white p-2 border shadow-sm mb-4">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.902442430139!2d90.39108031536293!3d23.75085809467643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b888ad3f988d%3A0x82cd856be2a81f30!2sDhanmondi%2C%20Dhaka%201205!5e0!3m2!1sen!2sbd!4v1625562235699!5m2!1sen!2sbd" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <div class="bg-white p-4 border shadow-sm">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Departmental Communication</h5>
                    <ul class="list-unstyled dept-list m-0">
                        <li>
                            <span class="fw-bold text-dark">News Desk</span>
                            <a href="mailto:news@dailybanglatimes.com" class="text-danger text-decoration-none small">#</a>
                        </li>
                        <li>
                            <span class="fw-bold text-dark">Advertisement Department</span>
                            <a href="mailto:ad@dailybanglatimes.com" class="text-danger text-decoration-none small">#</a>
                        </li>
                        <li>
                            <span class="fw-bold text-dark">Circulation</span>
                            <a href="mailto:circ@dailybanglatimes.com" class="text-danger text-decoration-none small">#</a>
                        </li>
                        <li>
                            <span class="fw-bold text-dark">Editorial</span>
                            <a href="mailto:editor@dailybanglatimes.com" class="text-danger text-decoration-none small">#</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection