document.addEventListener('DOMContentLoaded', () => {
    const loginRole = document.getElementById('login-role');
    const loginIdInput = document.querySelector('[data-login-id-input]');
    const loginIdLabel = document.querySelector('[data-login-id-label]');
    const roleLabels = { student: 'Student ID', teacher: 'Employee ID', admin: 'Administrator Username' };

    const updateLoginIdLabel = () => {
        if (!loginRole || !loginIdInput || !loginIdLabel) return;
        const label = roleLabels[loginRole.value] || 'Student ID';
        loginIdInput.placeholder = label;
        loginIdLabel.textContent = label;
        loginIdInput.type = 'text';
        loginIdInput.autocomplete = 'username';
    };

    loginRole?.addEventListener('change', updateLoginIdLabel);
    updateLoginIdLabel();

    const passwordToggle = document.querySelector('[data-password-toggle]');
    const passwordInput = document.getElementById('password');

    passwordToggle?.addEventListener('change', () => {
        if (!passwordInput) return;
        passwordInput.type = passwordToggle.checked ? 'text' : 'password';
    });

    const toggle = document.querySelector('[data-menu-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const overlay = document.querySelector('[data-sidebar-overlay]');
    const closeButton = document.querySelector('[data-menu-close]');

    if (!toggle || !sidebar || !overlay) return;

    const closeMenu = (restoreFocus = false) => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Open navigation');
        if (restoreFocus) toggle.focus();
    };

    toggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('is-open');
        overlay.classList.toggle('is-visible', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
        if (isOpen) closeButton?.focus();
    });

    overlay.addEventListener('click', () => closeMenu());
    closeButton?.addEventListener('click', () => closeMenu(true));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && sidebar.classList.contains('is-open')) closeMenu(true);
    });

    document.querySelectorAll('[data-copy-code]').forEach((button) => {
        button.addEventListener('click', async () => {
            await navigator.clipboard?.writeText(button.dataset.copyCode);
            button.textContent = 'Copied';
            window.setTimeout(() => { button.textContent = 'Copy'; }, 1500);
        });
    });

    const classroomForm = document.querySelector('[data-classroom-form]');
    classroomForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        const data = new FormData(classroomForm);
        const preview = document.querySelector('[data-classroom-preview]');
        const joiningCode = `${String(data.get('subject_code')).replace(/[^a-z0-9]/gi, '').toUpperCase().slice(0, 5)}-DEMO`;
        preview.querySelector('[data-preview-code]').textContent = data.get('subject_code');
        preview.querySelector('[data-preview-name]').textContent = data.get('subject_name');
        preview.querySelector('[data-preview-meta]').textContent = `${data.get('section')} · ${data.get('semester')} · AY ${data.get('academic_year')}`;
        preview.querySelector('[data-preview-description]').textContent = data.get('classroom_description');
        preview.querySelector('[data-preview-join]').textContent = joiningCode;
        preview.hidden = false;
        preview.querySelector('[data-copy-preview]').dataset.copyCode = joiningCode;
        preview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    document.querySelector('[data-copy-preview]')?.addEventListener('click', async (event) => {
        await navigator.clipboard?.writeText(event.currentTarget.dataset.copyCode);
        event.currentTarget.textContent = 'Copied';
    });

    const joinForm = document.querySelector('[data-join-form]');
    joinForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        const code = new FormData(joinForm).get('class_code').trim().toUpperCase();
        const match = document.querySelector('[data-join-match]');
        const message = document.querySelector('[data-join-message]');
        match.hidden = code !== 'CCIT-2026';
        message.textContent = code === 'CCIT-2026' ? 'Demonstration classroom found.' : 'No demonstration classroom matches that code. Try CCIT-2026.';
        message.classList.toggle('is-error', code !== 'CCIT-2026');
    });

    document.querySelector('[data-confirm-join]')?.addEventListener('click', (event) => {
        event.currentTarget.hidden = true;
        document.querySelector('[data-pending-confirmation]').hidden = false;
        sessionStorage.setItem('cityCollegeDemoJoinStatus', 'pending');
    });

    document.querySelectorAll('[data-enrollment-request]').forEach((request) => {
        const id = request.dataset.enrollmentRequest;
        const setStatus = (status) => {
            const statusLabel = request.querySelector('[data-request-status]');
            statusLabel.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            statusLabel.className = `status-chip status-${status}`;
            request.querySelectorAll('[data-request-action]').forEach((button) => { button.disabled = true; });
        };
        const savedStatus = sessionStorage.getItem(`cityCollegeEnrollment:${id}`);
        if (savedStatus) setStatus(savedStatus);
        request.querySelectorAll('[data-request-action]').forEach((button) => {
            button.addEventListener('click', () => {
                sessionStorage.setItem(`cityCollegeEnrollment:${id}`, button.dataset.requestAction);
                setStatus(button.dataset.requestAction);
            });
        });
    });

    document.querySelectorAll('[data-classroom-tab]').forEach((tab) => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('[data-classroom-tab]').forEach((item) => {
                item.classList.toggle('is-active', item === tab);
                item.setAttribute('aria-selected', String(item === tab));
            });
            document.querySelectorAll('[data-classroom-panel]').forEach((panel) => {
                panel.hidden = panel.dataset.classroomPanel !== tab.dataset.classroomTab;
            });
        });
    });

    const discussionStream = document.querySelector('[data-discussion-stream]');
    if (discussionStream) {
        const portal = discussionStream.dataset.portal;
        const feed = discussionStream.querySelector('[data-post-feed]');
        const storageKey = `cityCollegePosts:${portal}`;
        const author = portal === 'teacher' ? 'Prof. Mira Santos' : 'Alex Rivera';
        const role = portal === 'teacher' ? 'Teacher' : 'Student';

        const createPostElement = (post) => {
            const article = document.createElement('article');
            article.className = `discussion-post${post.announcement ? ' teacher-announcement' : ''}`;
            article.dataset.postId = post.id;
            article.dataset.ownedPost = 'true';
            article.innerHTML = `<header><div class="avatar">${portal === 'teacher' ? 'MS' : 'AR'}</div><div><strong>${author}</strong><span>${role} · Just now</span></div>${post.announcement ? '<span class="announcement-label">Official announcement</span>' : ''}</header><p data-post-content></p><footer><span data-comment-count>0 comments</span><button type="button" data-toggle-comments>Reply</button><button type="button" data-edit-post>Edit</button><button type="button" data-delete-post>Delete</button></footer><div class="post-comments" data-comments hidden><form data-comment-form><input name="comment" required placeholder="Write a reply…"><button type="submit">Reply</button></form></div>`;
            article.querySelector('[data-post-content]').textContent = post.content;
            return article;
        };

        JSON.parse(sessionStorage.getItem(storageKey) || '[]').forEach((post) => feed.prepend(createPostElement(post)));

        discussionStream.querySelector('[data-post-form]')?.addEventListener('submit', (event) => {
            event.preventDefault();
            const form = event.currentTarget;
            const content = form.elements.content.value.trim();
            const feedback = form.querySelector('[data-post-feedback]');
            if (!content) {
                feedback.textContent = 'Write a message before posting.';
                feedback.classList.add('is-error');
                return;
            }
            const posts = JSON.parse(sessionStorage.getItem(storageKey) || '[]');
            const post = { id: `post-${Date.now()}`, content, announcement: Boolean(form.elements.announcement?.checked) };
            posts.push(post);
            sessionStorage.setItem(storageKey, JSON.stringify(posts));
            feed.prepend(createPostElement(post));
            form.reset();
            feedback.textContent = 'Demonstration post added to this browser session.';
            feedback.classList.remove('is-error');
        });

        feed.addEventListener('click', (event) => {
            const post = event.target.closest('[data-post-id]');
            if (!post) return;
            if (event.target.matches('[data-toggle-comments]')) {
                const comments = post.querySelector('[data-comments]');
                comments.hidden = !comments.hidden;
                if (!comments.hidden) comments.querySelector('input')?.focus();
            }
            if (event.target.matches('[data-delete-post], [data-moderate-post]')) {
                post.remove();
                if (post.dataset.ownedPost) {
                    const posts = JSON.parse(sessionStorage.getItem(storageKey) || '[]').filter((item) => item.id !== post.dataset.postId);
                    sessionStorage.setItem(storageKey, JSON.stringify(posts));
                }
            }
            if (event.target.matches('[data-edit-post]')) {
                const content = post.querySelector('[data-post-content]');
                const updated = window.prompt('Edit your demonstration post:', content.textContent);
                if (updated?.trim()) {
                    content.textContent = updated.trim();
                    const posts = JSON.parse(sessionStorage.getItem(storageKey) || '[]');
                    const savedPost = posts.find((item) => item.id === post.dataset.postId);
                    if (savedPost) savedPost.content = updated.trim();
                    sessionStorage.setItem(storageKey, JSON.stringify(posts));
                }
            }
        });

        feed.addEventListener('submit', (event) => {
            const form = event.target.closest('[data-comment-form]');
            if (!form) return;
            event.preventDefault();
            const input = form.elements.comment;
            if (!input.value.trim()) return;
            const comment = document.createElement('div');
            comment.className = 'comment';
            const name = document.createElement('strong');
            const body = document.createElement('p');
            name.textContent = author;
            body.textContent = input.value.trim();
            comment.append(name, body);
            form.before(comment);
            input.value = '';
            const post = form.closest('[data-post-id]');
            const count = post.querySelectorAll('.comment').length;
            post.querySelector('[data-comment-count]').textContent = `${count} ${count === 1 ? 'comment' : 'comments'}`;
        });
    }

    const messaging = document.querySelector('[data-messaging]');
    if (messaging) {
        const conversations = messaging.querySelectorAll('[data-conversation]');
        const panel = messaging.querySelector('[data-message-panel]');
        const conversationData = {};
        conversations.forEach((conversation) => {
            conversationData[conversation.dataset.conversation] = {
                name: conversation.querySelector('strong').textContent,
                subject: conversation.querySelector('small').textContent,
            };
            conversation.addEventListener('click', () => {
                conversations.forEach((item) => item.classList.toggle('is-active', item === conversation));
                conversation.querySelector('b')?.remove();
                panel.querySelector('[data-message-name]').textContent = conversationData[conversation.dataset.conversation].name;
                panel.querySelector('[data-message-subject]').textContent = conversationData[conversation.dataset.conversation].subject;
                panel.dataset.activeConversation = conversation.dataset.conversation;
                messaging.classList.add('is-conversation-open');
            });
        });
        panel.dataset.activeConversation = conversations[0]?.dataset.conversation || '';
        messaging.querySelector('[data-message-back]')?.addEventListener('click', () => messaging.classList.remove('is-conversation-open'));
        messaging.querySelector('[data-message-form]')?.addEventListener('submit', (event) => {
            event.preventDefault();
            const form = event.currentTarget;
            const message = form.elements.message.value.trim();
            if (!message) return;
            const bubble = document.createElement('div');
            bubble.className = 'message-bubble is-sent';
            const body = document.createElement('p');
            const meta = document.createElement('span');
            body.textContent = message;
            meta.textContent = 'You · Just now';
            bubble.append(body, meta);
            messaging.querySelector('[data-message-history]').append(bubble);
            const key = `cityCollegeMessages:${messaging.dataset.portal}:${panel.dataset.activeConversation}`;
            const savedMessages = JSON.parse(sessionStorage.getItem(key) || '[]');
            savedMessages.push({ message, sentAt: new Date().toISOString() });
            sessionStorage.setItem(key, JSON.stringify(savedMessages));
            form.reset();
            form.querySelector('[data-message-feedback]').textContent = 'Saved in this browser session only. It was not delivered.';
            bubble.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    }

    const assignmentForm = document.querySelector('[data-assignment-form]');
    if (assignmentForm) {
        const feedback = assignmentForm.querySelector('[data-assignment-feedback]');
        const preview = document.querySelector('[data-assignment-preview]');
        const formatManilaDate = (value) => new Intl.DateTimeFormat('en-PH', { dateStyle: 'medium', timeStyle: 'short', timeZone: 'Asia/Manila' }).format(new Date(value));
        const validateAssignment = () => {
            if (!assignmentForm.reportValidity()) return false;
            const available = new Date(assignmentForm.elements.available_at.value);
            const deadline = new Date(assignmentForm.elements.deadline_at.value);
            if (deadline <= available) {
                feedback.textContent = 'The submission deadline must be later than the availability date.';
                feedback.classList.add('is-error');
                return false;
            }
            if (Number(assignmentForm.elements.points.value) <= 0) {
                feedback.textContent = 'Maximum points must be greater than zero.';
                feedback.classList.add('is-error');
                return false;
            }
            feedback.classList.remove('is-error');
            return true;
        };
        const showAssignmentPreview = (status) => {
            if (!validateAssignment()) return;
            const data = new FormData(assignmentForm);
            preview.querySelector('[data-assignment-preview-status]').textContent = status;
            preview.querySelector('[data-assignment-preview-status]').className = `status-chip status-${status.toLowerCase()}`;
            preview.querySelector('[data-assignment-preview-classroom]').textContent = data.get('classroom');
            preview.querySelector('[data-assignment-preview-title]').textContent = data.get('title');
            preview.querySelector('[data-assignment-preview-instructions]').textContent = data.get('instructions');
            preview.querySelector('[data-assignment-preview-available]').textContent = formatManilaDate(data.get('available_at'));
            preview.querySelector('[data-assignment-preview-deadline]').textContent = formatManilaDate(data.get('deadline_at'));
            preview.querySelector('[data-assignment-preview-type]').textContent = data.get('submission_type');
            preview.querySelector('[data-assignment-preview-points]').textContent = data.get('points');
            preview.hidden = false;
            preview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        };
        assignmentForm.querySelectorAll('[data-assignment-action]').forEach((button) => {
            button.addEventListener('click', () => {
                const action = button.dataset.assignmentAction;
                showAssignmentPreview(action === 'draft' ? 'Draft' : 'Preview');
                if (action === 'draft' && !feedback.classList.contains('is-error')) {
                    sessionStorage.setItem('cityCollegeAssignmentDraft', JSON.stringify(Object.fromEntries(new FormData(assignmentForm))));
                    feedback.textContent = 'Draft saved in this browser session only.';
                }
            });
        });
        assignmentForm.addEventListener('submit', (event) => {
            event.preventDefault();
            if (!validateAssignment()) return;
            assignmentForm.elements.status.value = 'published';
            sessionStorage.setItem('cityCollegePublishedAssignment', JSON.stringify(Object.fromEntries(new FormData(assignmentForm))));
            showAssignmentPreview('Published');
            feedback.textContent = 'Demonstration assignment published in this browser session. No students were notified.';
        });
    }

    const assignmentSearch = document.querySelector('[data-assignment-search]');
    const assignmentStatus = document.querySelector('[data-assignment-status]');
    const filterAssignments = () => {
        const query = assignmentSearch?.value.trim().toLowerCase() || '';
        const status = assignmentStatus?.value || 'all';
        let visibleCount = 0;
        document.querySelectorAll('[data-assignment-card]').forEach((card) => {
            const visible = card.dataset.search.includes(query) && (status === 'all' || card.dataset.status === status);
            card.hidden = !visible;
            if (visible) visibleCount += 1;
        });
        document.querySelector('[data-assignment-empty]')?.toggleAttribute('hidden', visibleCount > 0);
    };
    assignmentSearch?.addEventListener('input', filterAssignments);
    assignmentStatus?.addEventListener('change', filterAssignments);

    document.querySelectorAll('[data-detail-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const feedback = document.querySelector('[data-detail-feedback]');
            if (button.dataset.detailAction === 'deadline') {
                const deadline = window.prompt('Enter a new demonstration deadline:', 'October 2, 2026 · 11:59 PM');
                if (!deadline?.trim()) return;
                document.querySelector('[data-detail-deadline]').textContent = deadline.trim();
                feedback.textContent = 'Demonstration deadline updated for this page only.';
            } else if (button.dataset.detailAction === 'close') {
                document.querySelector('[data-detail-status]').textContent = 'Closed';
                document.querySelector('[data-detail-status]').className = 'status-chip status-closed';
                feedback.textContent = 'Submissions are marked closed in this demonstration.';
            } else {
                feedback.textContent = 'Edit Assignment is a demonstration control. Use Create Assignment to preview editable fields.';
            }
        });
    });

    document.querySelector('[data-submission-filter]')?.addEventListener('change', (event) => {
        document.querySelectorAll('[data-submission-row]').forEach((row) => {
            row.hidden = event.target.value !== 'all' && row.dataset.status !== event.target.value;
        });
    });
    document.querySelectorAll('[data-view-submission]').forEach((button) => {
        button.addEventListener('click', () => {
            const panel = document.querySelector('[data-grading-panel]');
            panel.querySelector('[data-grading-student]').textContent = button.dataset.student;
            panel.querySelector('[data-grading-meta]').textContent = `${button.dataset.studentId} · Digital Literacy Reflection`;
            panel.querySelector('[data-grading-content]').hidden = false;
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
    document.querySelector('[data-grading-form]')?.addEventListener('submit', (event) => {
        event.preventDefault();
        const form = event.currentTarget;
        const score = Number(form.elements.score.value);
        const feedback = form.querySelector('[data-grading-feedback]');
        if (score < 0 || score > 100) {
            feedback.textContent = 'Enter a score from 0 to 100.';
            feedback.classList.add('is-error');
            return;
        }
        feedback.textContent = 'Grade preview created. Nothing was stored or released.';
        feedback.classList.remove('is-error');
        document.querySelector('[data-grade-score]').textContent = score;
        document.querySelector('[data-grade-comment]').textContent = form.elements.feedback.value;
        document.querySelector('[data-grade-preview]').hidden = false;
    });
});
