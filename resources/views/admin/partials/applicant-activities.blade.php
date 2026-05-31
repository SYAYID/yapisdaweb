@php
    $activityOptions = [
        'note' => ['label' => 'Catatan', 'icon' => 'fa-note-sticky'],
        'document' => ['label' => 'Berkas', 'icon' => 'fa-folder-open'],
        'phone' => ['label' => 'Telepon', 'icon' => 'fa-phone'],
        'visit' => ['label' => 'Kunjungan', 'icon' => 'fa-location-dot'],
        'payment' => ['label' => 'Keuangan', 'icon' => 'fa-wallet'],
        'warning' => ['label' => 'Perhatian', 'icon' => 'fa-triangle-exclamation'],
    ];

    $activities = collect($activities ?? []);
@endphp

<div class="admin-activity-panel">
    <section class="admin-activity-card admin-activity-form-card">
        <div class="admin-activity-card-head">
            <span class="admin-activity-head-icon"><i class="fas fa-clipboard-list"></i></span>
            <div>
                <h3>Catatan Tindak Lanjut</h3>
                <p>Simpan kekurangan berkas, hasil kontak orang tua, atau jadwal follow-up.</p>
            </div>
        </div>

        <form action="{{ $activityStoreRoute }}" method="POST" class="admin-activity-form">
            @csrf

            <div class="admin-activity-field">
                <label for="activity_category">Jenis</label>
                <select name="category" id="activity_category">
                    @foreach($activityOptions as $value => $option)
                        <option value="{{ $value }}" {{ old('category', 'note') === $value ? 'selected' : '' }}>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="admin-activity-field">
                <label for="activity_body">Catatan</label>
                <textarea name="body" id="activity_body" rows="4" maxlength="2000" required
                          placeholder="Contoh: KK sudah jelas, rapor perlu diupload ulang halaman nilai semester 5.">{{ old('body') }}</textarea>
                @error('body')
                    <small class="admin-activity-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="admin-activity-inline">
                <div class="admin-activity-field">
                    <label for="activity_follow_up_at">Follow-up</label>
                    <input type="datetime-local" name="follow_up_at" id="activity_follow_up_at" value="{{ old('follow_up_at') }}">
                </div>

                <label class="admin-activity-check">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}>
                    <span>Tandai penting</span>
                </label>
            </div>

            <button type="submit" class="admin-activity-submit">
                <i class="fas fa-plus"></i>
                Simpan Catatan
            </button>
        </form>
    </section>

    <section class="admin-activity-card admin-activity-timeline-card">
        <div class="admin-activity-card-head">
            <span class="admin-activity-head-icon"><i class="fas fa-clock-rotate-left"></i></span>
            <div>
                <h3>Timeline Aktivitas</h3>
                <p>{{ $activities->count() }} aktivitas terakhir untuk pendaftar ini.</p>
            </div>
        </div>

        <div class="admin-activity-list">
            @forelse($activities as $activity)
                <article class="admin-activity-item {{ $activity->is_pinned ? 'is-pinned' : '' }}">
                    <span class="admin-activity-dot">
                        <i class="fas {{ $activity->category_icon }}"></i>
                    </span>
                    <div class="admin-activity-content">
                        <div class="admin-activity-meta">
                            <span class="admin-activity-badge">{{ $activity->category_label }}</span>
                            @if($activity->is_pinned)
                                <span class="admin-activity-pin"><i class="fas fa-thumbtack"></i>Penting</span>
                            @endif
                            <time>{{ $activity->created_at?->format('d/m/Y H:i') }}</time>
                        </div>
                        <h4>{{ $activity->title }}</h4>
                        @if($activity->body)
                            <p>{{ $activity->body }}</p>
                        @endif
                        <div class="admin-activity-foot">
                            <span><i class="fas fa-user-shield"></i>{{ $activity->user->name ?? 'Sistem' }}</span>
                            @if($activity->follow_up_at)
                                <span><i class="fas fa-calendar-check"></i>Follow-up {{ $activity->follow_up_at->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="admin-activity-empty">
                    <i class="fas fa-inbox"></i>
                    <strong>Belum ada catatan</strong>
                    <span>Catatan pertama akan muncul di sini setelah disimpan.</span>
                </div>
            @endforelse
        </div>
    </section>
</div>
