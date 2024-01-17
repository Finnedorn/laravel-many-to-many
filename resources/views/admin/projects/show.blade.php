@extends('layouts.app')

@section('content')
    <main>
        <div id="character-detail" class="container py-5">
            <div class="row pt-5">
                <div class="container">
                    <div>
                        <div class="d-flex justify-content-between  align-items-center w-75">
                            <h1 class="pb-3">
                                {{ $project->project_title }}
                            </h1>
                            {{-- bottone di edit --}}
                            <a href="{{route('admin.projects.edit', $project->id)}}">
                                <button class="btn btn-success rounded-3 border-0">
                                    <i class="fa-solid fa-pen" style="font-size: 0.7rem"></i>
                                </button>
                            </a>
                        </div>
                        <h4>
                            Nome Repository: {{$project->repo_name}}
                        </h4>
                        @if($project->category !== null)
                        <h6>
                            Categoria: {{$project->category->name}}
                        </h6>
                        @endif
                        <h6>
                            Link alla Repository: {{$project->repo_link}}
                        </h6>
                        <p class="my-4">
                            {{$project->description}}
                        </p>
                        {{-- preview spot --}}
                        @if ($project->preview !== null)
                            <div class="img-box my-4 rounded-3 overflow-hidden ">
                                <img src="{{asset('storage/'. $project->preview)}}" alt="{{$project->project_title}}">
                            </div>
                        @else
                            <div>preview attualmente non disponibile</div>
                        @endif
                        <div class="pt-4">
                            <a href="{{route('admin.projects.index')}}">
                                <i class="fa-solid fa-chevron-left text-primary" style="font-size: 2.5rem"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
