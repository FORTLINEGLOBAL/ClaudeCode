-- Fortline Global — State DB Schema
-- Isolated from Flexor. Separate Postgres instance.

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE accounts (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    org_name VARCHAR(255) NOT NULL,
    domain VARCHAR(255),
    vertical VARCHAR(100),         -- 'uae_hospitality', 'israel_defense', 'uae_healthcare', etc.
    geography VARCHAR(100),        -- 'UAE', 'Israel', 'Ukraine', 'KSA', etc.
    icp_fit_score INT,
    notes TEXT,
    first_seen_at TIMESTAMP DEFAULT NOW(),
    last_activity_at TIMESTAMP
);

CREATE TABLE contacts (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    account_id UUID REFERENCES accounts(id),
    full_name VARCHAR(255) NOT NULL,
    role VARCHAR(255),
    email VARCHAR(255),
    linkedin_url VARCHAR(500),
    icp_fit_score INT,
    last_contacted_at TIMESTAMP,
    nurture_until DATE,            -- skip until this date (post-break-up)
    blocklisted BOOLEAN DEFAULT FALSE
);

CREATE TABLE drafts (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    contact_id UUID REFERENCES contacts(id),
    agent VARCHAR(50),             -- 'fortline-prospector', 'fortline-followup-tracker'
    template_version VARCHAR(10),  -- 'v2', 'v2.1', 'v2.2'
    template_reason TEXT,          -- why this version was selected
    draft_type VARCHAR(50),        -- 'email_cold', 'dm_long', 'dm_short_reminder',
                                   -- 'dm_short_standalone', 'email_followup_2',
                                   -- 'email_followup_3_dm', 'email_breakup'
    subject TEXT,
    body TEXT,
    hooks JSONB,                   -- [{hook: "...", source_url: "...", verified: true, domain: "..."}]
    enrichment_json JSONB,
    reasoning_trace TEXT,
    created_at TIMESTAMP DEFAULT NOW(),
    status VARCHAR(50) DEFAULT 'queued', -- 'queued', 'approved', 'edited', 'killed', 'sent', 'replied'
    kill_reason TEXT,
    edit_diff TEXT,
    decided_at TIMESTAMP,
    sent_at TIMESTAMP,
    replied_at TIMESTAMP,
    reply_sentiment VARCHAR(20)    -- 'positive', 'neutral', 'negative', 'ooo'
);

CREATE TABLE threads (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    contact_id UUID REFERENCES contacts(id),
    channel VARCHAR(20),           -- 'email', 'linkedin'
    started_at TIMESTAMP DEFAULT NOW(),
    last_message_at TIMESTAMP,
    last_message_direction VARCHAR(10),  -- 'sent', 'received'
    touchpoint_count INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active'  -- 'active', 'replied', 'dead', 'meeting_booked', 'nurture_quarterly'
);

CREATE TABLE icp_briefs (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    description TEXT,
    target_volume_per_week INT DEFAULT 10,
    active BOOLEAN DEFAULT TRUE,
    criteria_json JSONB,           -- {verticals, geographies, roles, size_min, size_max, ...}
    created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE blocklist (
    email VARCHAR(255) PRIMARY KEY,
    reason TEXT,
    added_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE source_url_reputation (
    domain VARCHAR(255) PRIMARY KEY,
    status VARCHAR(20) DEFAULT 'unknown',  -- 'trusted', 'untrusted', 'unknown'
    times_used INT DEFAULT 0,
    times_killed_due_to_source INT DEFAULT 0,
    last_decided_at TIMESTAMP
);

CREATE TABLE weekly_metrics (
    week_starting DATE PRIMARY KEY,
    drafts_created INT DEFAULT 0,
    drafts_sent INT DEFAULT 0,
    replies_received INT DEFAULT 0,
    meetings_booked INT DEFAULT 0,
    template_v22_replies INT DEFAULT 0,
    template_v21_replies INT DEFAULT 0,
    template_v2_replies INT DEFAULT 0,
    voice_profile_version INT DEFAULT 1
);

-- Indexes for hot query paths
CREATE INDEX idx_contacts_last_contacted ON contacts(last_contacted_at);
CREATE INDEX idx_contacts_blocklisted ON contacts(blocklisted);
CREATE INDEX idx_contacts_nurture_until ON contacts(nurture_until);
CREATE INDEX idx_drafts_status ON drafts(status);
CREATE INDEX idx_drafts_contact_id ON drafts(contact_id);
CREATE INDEX idx_drafts_created_at ON drafts(created_at);
CREATE INDEX idx_threads_contact_id ON threads(contact_id);
CREATE INDEX idx_threads_status ON threads(status);
CREATE INDEX idx_accounts_vertical ON accounts(vertical);
CREATE INDEX idx_accounts_geography ON accounts(geography);

-- Seed trusted source domains
INSERT INTO source_url_reputation (domain, status) VALUES
    ('reuters.com', 'trusted'),
    ('bloomberg.com', 'trusted'),
    ('ft.com', 'trusted'),
    ('wsj.com', 'trusted'),
    ('thenational.ae', 'trusted'),
    ('gulfnews.com', 'trusted'),
    ('khaleejtimes.com', 'trusted'),
    ('haaretz.com', 'trusted'),
    ('timesofisrael.com', 'trusted'),
    ('janes.com', 'trusted'),
    ('defensenews.com', 'trusted'),
    ('linkedin.com', 'trusted'),
    ('arabianbusiness.com', 'trusted'),
    ('zawya.com', 'trusted'),
    ('constructionweekline.com', 'trusted'),
    ('hospitalitynet.org', 'trusted'),
    ('hotelnewsme.com', 'trusted'),
    ('aviationweek.com', 'trusted'),
    ('globaldefensecorp.com', 'untrusted'),
    ('securityblogwatch.com', 'untrusted')
ON CONFLICT (domain) DO NOTHING;
