DELIMITER $$
CREATE TRIGGER update_score_assessment_users AFTER INSERT ON assessment_peer_rubrics
FOR EACH ROW
BEGIN
SET @sumScores=(
	SELECT SUM(apr.weight * apr.score) AS sumScores FROM assessment_peer_rubrics apr
	WHERE apr.assessment_peer_id = NEW.assessment_peer_id
);

UPDATE assessment_peers
SET score = @sumScores
WHERE id = NEW.assessment_peer_id;
END
$$
